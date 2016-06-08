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

use GuzzleHttp\Message\RequestInterface;
use Usabilla\API\Credentials\Credentials;

class Signature
{
    /** @var string Cache of the default empty entity-body payload */
    const DEFAULT_PAYLOAD = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855';

    const ISO8601 = 'Ymd\THis\Z';
    const RFC1123 = 'D, d M Y H:i:s \G\M\T';

    /**
     * @param RequestInterface $request
     * @param Credentials $credentials
     *
     * @return RequestInterface
     */
    public function signRequest(RequestInterface $request, Credentials $credentials)
    {
        $timestamp = (new \DateTime('now'))->getTimestamp();
        $longDate = gmdate(self::ISO8601, $timestamp);
        $request->addHeader('Date', gmdate(self::RFC1123, $timestamp));

        $shortDate = substr($longDate, 0, 8);
        $credentialScope = $this->createScope($shortDate);
        $signingContext = $this->createSigningContext($request, $this->getPayload($request));
        $signingContext['string_to_sign'] = $this->createStringToSign($longDate, $credentialScope, $signingContext['canonical_request']);

        // Calculate the signing key using a series of derived keys
        $signature = hash_hmac('sha256', $signingContext['string_to_sign'], $this->getSigningKey($shortDate, $credentials->getSecretKey()));

        $request->addHeader(
            'Authorization', sprintf(
                'USBL1-HMAC-SHA256 Credential=%s/%s, SignedHeaders=%s, Signature=%s',
                $credentials->getAccessKey(),
                $credentialScope,
                $signingContext['signed_headers'],
                $signature
            )
        );

        return $request;
    }

    /**
     * Get the payload part of a signature from a request.
     *
     * @param RequestInterface $request
     *
     * @return string
     */
    private function getPayload(RequestInterface $request)
    {
        if ($request->hasHeader('x-usbl-content-sha256')) {
            return (string)$request->getHeader('x-usbl-content-sha256');
        }

        return self::DEFAULT_PAYLOAD;
    }

    /**
     * @param string $shortDate
     *
     * @return string
     */
    private function createScope($shortDate)
    {
        return sprintf('%s/usbl1_request', $shortDate);
    }

    /**
     * Create the canonical representation of a request
     *
     * @param RequestInterface $request Request to canonicalize
     * @param string           $payload Request payload
     *
     * @return array Returns an array of context information including:
     *               - canonical_request
     *               - signed_headers
     */
    private function createSigningContext(RequestInterface $request, $payload)
    {
        $canonHeaders = [];
        foreach ($request->getHeaders() as $key => $values) {
            $key = strtolower($key);
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

        $canon = sprintf(
            "%s\n%s\n%s\n%s\n\n%s\n%s",
            $request->getMethod(),
            $this->createCanonicalizedPath($request),
            $this->getCanonicalizedQueryString($request),
            implode("\n", $canonHeaders),
            $signedHeadersString,
            $payload
        );

        return [
            'canonical_request' => $canon,
            'signed_headers'    => $signedHeadersString
        ];
    }

    /**
     * @param RequestInterface $request
     *
     * @return string
     */
    private function createCanonicalizedPath(RequestInterface $request)
    {
        return $request->getPath();
    }

    /**
     * Get the canonicalized query string for a request
     *
     * @param  RequestInterface $request
     *
     * @return string
     */
    private function getCanonicalizedQueryString(RequestInterface $request)
    {
        $queryParamsKeys = $request->getQuery()->getKeys();

        $signatureKey = array_search('X-Usbl-Signature', $queryParamsKeys);
        if (false !== $signatureKey) {
            unset($queryParamsKeys[$signatureKey]);
        }
        if (empty($queryParamsKeys)) {
            return '';
        }

        ksort($queryParamsKeys);

        $qs = '';
        foreach ($queryParamsKeys as $key) {
            $values = $request->getQuery()->get($key);
            if (is_array($values)) {
                sort($values);
            } elseif ($values === 0) {
                $values = ['0'];
            } elseif (!$values) {
                $values = [''];
            }
            foreach ((array)$values as $value) {
                $qs .= rawurlencode($key) . '=' . rawurlencode($value) . '&';
            }
        }

        return substr($qs, 0, -1);
    }

    /**
     * @param string $longDate
     * @param string $credentialScope
     * @param string $creq
     *
     * @return string
     */
    private function createStringToSign($longDate, $credentialScope, $creq)
    {
        return sprintf("USBL1-HMAC-SHA256\n%s\n%s\n%s", $longDate, $credentialScope, hash('sha256', $creq));
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
        return hash_hmac('sha256', 'usbl1_request', hash_hmac('sha256', $shortDate, 'USBL1' . $secretKey, true), true);
    }
}