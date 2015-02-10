<?php

/**
 * Copyright Usabilla.com. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * https://github.com/usabilla/api-php/blob/master/LICENSE.MD
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Usabilla\API\Signature;


use Usabilla\API\Credentials\Credentials;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\QueryString;
use Guzzle\Http\Message\EntityEnclosingRequestInterface;
use Guzzle\Http\Message\RequestFactory;

class Signature
{


    /** @var int Maximum number of hashes to cache */
    protected $maxCacheSize = 50;
    /** @var array Cache of previously signed values */
    protected $hashCache = array();
    /** @var int Size of the hash cache */
    protected $cacheSize = 0;

    public $signature;

    /** @var string Cache of the default empty entity-body payload */
    const DEFAULT_PAYLOAD = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855';


    const ISO8601 = 'Ymd\THis\Z';
    const ISO8601_S3 = 'Y-m-d\TH:i:s\Z';
    const RFC1123 = 'D, d M Y H:i:s \G\M\T';
    const RFC2822 = \DateTime::RFC2822;
    const SHORT = 'Ymd';


    public function signRequest(RequestInterface $request, Credentials $credentials)
    {

        $now = new \DateTime('now');
        $timestamp = $now->getTimestamp();
        $longDate = gmdate(self::ISO8601, $timestamp);


        $shortDate = substr($longDate, 0, 8);



        $request->setHeader('Date', gmdate(self::RFC1123, $timestamp));



        $signature = $this->generateSignature($credentials->getSecretKey());
        $payload = $this->getPayload($request);
        $credentialScope = $this->createScope($shortDate);
        $signingContext = $this->createSigningContext($request, $payload);
        $signingContext['string_to_sign'] = $this->createStringToSign(
            $longDate,
            $credentialScope,
            $signingContext['canonical_request']
        );


        // Calculate the signing key using a series of derived keys
        $signingKey = $this->getSigningKey($shortDate, $credentials->getSecretKey());
        $signature = hash_hmac('sha256', $signingContext['string_to_sign'], $signingKey);


        $request->setHeader('Authorization', "USBL1-HMAC-SHA256 "
            . "Credential={$credentials->getAccessKeyId()}/{$credentialScope}, "
            . "SignedHeaders={$signingContext['signed_headers']}, Signature={$signature}");

        // Add debug information to the request
        $request->getParams()->set('usbl.signature', $signingContext);
    }

    public function generateSignature($secretToken, $data = array())
    {
        //sort data array alphabetically by key
        ksort($data);
        //combine keys and values into one long string
        $dataString = "";
        foreach ($data as $key => $value) {
            $dataString .= $key . $value;
        }
        //lowercase everything
        $dataString = strtolower($dataString);
        //generate signature using the SHA256 hashing algorithm
        return hash_hmac("sha256", $dataString, $secretToken);
    }


    /**
     * Get the payload part of a signature from a request.
     *
     * @param RequestInterface $request
     *
     * @return string
     */
    protected function getPayload(RequestInterface $request)
    {
        // Calculate the request signature payload
        if ($request->hasHeader('x-usbl-content-sha256')) {
            return (string)$request->getHeader('x-usbl-content-sha256');
        }

        return self::DEFAULT_PAYLOAD;
    }


    private function createScope($shortDate)
    {
        return $shortDate
        . '/usbl1_request';
    }

    /**
     * Converts a POST request to a GET request by moving POST fields into the
     * query string.
     *
     * Useful for pre-signing query protocol requests.
     *
     * @param EntityEnclosingRequestInterface $request Request to clone
     *
     * @return RequestInterface
     * @throws \InvalidArgumentException if the method is not POST
     */
    public static function convertPostToGet(EntityEnclosingRequestInterface $request)
    {
        if ($request->getMethod() !== 'POST') {
            throw new \InvalidArgumentException('Expected a POST request but '
                . 'received a ' . $request->getMethod() . ' request.');
        }
        $cloned = RequestFactory::getInstance()
            ->cloneRequestWithMethod($request, 'GET');
        // Move POST fields to the query if they are present
        foreach ($request->getPostFields() as $name => $value) {
            $cloned->getQuery()->set($name, $value);
        }
        return $cloned;
    }

    /**
     * Create the canonical representation of a request
     *
     * @param RequestInterface $request Request to canonicalize
     * @param string $payload Request payload
     *
     * @return array Returns an array of context information including:
     *               - canonical_request
     *               - signed_headers
     */
    private function createSigningContext(RequestInterface $request, $payload)
    {
        // Normalize the path
        $canon = $request->getMethod() . "\n"
            . $this->createCanonicalizedPath($request) . "\n"
            . $this->getCanonicalizedQueryString($request) . "\n";
        $canonHeaders = array();


        foreach ($request->getHeaders()->getAll() as $key => $values) {
            $key = strtolower($key);
            $values = $values->toArray();

            if (count($values) == 1) {
                $values = $values[0];
            } else {
                sort($values);
                $values = implode(',', $values);
            }
            $canonHeaders[$key] = $key . ':' . preg_replace('/\s+/', ' ', $values);
        }
        ksort($canonHeaders);
        $signedHeadersString = implode(';', array_keys($canonHeaders));
        $canon .= implode("\n", $canonHeaders) . "\n\n"
            . $signedHeadersString . "\n"
            . $payload;
        return array(
            'canonical_request' => $canon,
            'signed_headers' => $signedHeadersString
        );
    }

    protected function createCanonicalizedPath(RequestInterface $request)
    {
        return $request->getPath();
    }


    /**
     * Get the canonicalized query string for a request
     *
     * @param  RequestInterface $request
     * @return string
     */
    private function getCanonicalizedQueryString(RequestInterface $request)
    {
        $queryParams = $request->getQuery()->getAll();
        unset($queryParams['X-Usbl-Signature']);
        if (empty($queryParams)) {
            return '';
        }
        $qs = '';
        ksort($queryParams);
        foreach ($queryParams as $key => $values) {

            if (is_array($values)) {
                sort($values);
            } elseif ($values === 0) {
                $values = array('0');
            } elseif (!$values) {
                $values = array('');
            }
            foreach ((array)$values as $value) {
                if ($value === QueryString::BLANK) {
                    $value = '';
                }
                $qs .= rawurlencode($key) . '=' . rawurlencode($value) . '&';
            }
        }
        return substr($qs, 0, -1);
    }


    private function createStringToSign($longDate, $credentialScope, $creq)
    {
        return "USBL1-HMAC-SHA256\n{$longDate}\n{$credentialScope}\n"
        . hash('sha256', $creq);
    }


    /**
     * Get a hash for a specific key and value.  If the hash was previously
     * cached, return it
     *
     * @param string $shortDate Short date
     * @param string $secretKey Secret Access Key
     *
     * @return string
     */
    private function getSigningKey($shortDate, $secretKey)
    {
        $cacheKey = $shortDate . '_' . $secretKey;

        $dateKey = hash_hmac('sha256', $shortDate, 'USBL1' . $secretKey, true);
        $this->hashCache[$cacheKey] = hash_hmac('sha256', 'usbl1_request', $dateKey, true);

        return $this->hashCache[$cacheKey];
    }

}