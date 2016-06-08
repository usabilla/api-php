<?php

/**
 * Copyright Usabilla.com. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * https://github.com/usabilla/php-client
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Usabilla\Tests\API\Signature;

use GuzzleHttp\Message\Request;
use Usabilla\API\Signature\Signature;

class SignatureTest extends \PHPUnit_Framework_TestCase
{
    /** @var Signature */
    private $signature;
    
    const DEFAULT_DATETIME = 'Mon, 09 Sep 2011 23:36:00 GMT';

    const ISO8601    = 'Ymd\THis\Z';
    const ISO8601_S3 = 'Y-m-d\TH:i:s\Z';
    const RFC1123    = 'D, d M Y H:i:s \G\M\T';
    const RFC2822    = \DateTime::RFC2822;
    const SHORT      = 'Ymd';

    public function setUp()
    {
        $this->signature = new Signature();
    }

    public function testSignsRequests()
    {
        $request = $this->createRequest();

        $contentHash = hash('sha256', 'foobar');
        $request->setHeader('x-usbl-content-sha256', $contentHash);

        $this->signature->signRequest($request, DEFAULT_KEY, DEFAULT_SECRET);
    }

    public function testRequestDefaultPayload()
    {
        $request = $this->createRequest();

        $this->signature->signRequest($request, DEFAULT_KEY, DEFAULT_SECRET);
    }

    public function queryStringProvider()
    {
        return [
            [[ 'Foo' => '', 'a' => 0, ], 'Foo=&a=0'],
            [[ 'Foo' => '', 'a' => '', ], 'Foo=&a='],
            [[ ], ''],
            [[ 'X-Usbl-Signature' => 'foo'], ''],
            [[ 'Foo' => '123', 'Bar' => '456' ], 'Foo=123&Bar=456'],
            [[ 'Foo' => ['b', 'a'], 'a' => 'bc' ], 'Foo=a&Foo=b&a=bc'],
            [[ 'Foo' => '', 'a' => 'b' ], 'Foo=&a=b'],
        ];
    }

    /**
     * @dataProvider queryStringProvider
     */
    public function testCreatesCanonicalizedQueryString($headers, $string)
    {
        // Make the method publicly callable
        $method = new \ReflectionMethod('Usabilla\Api\Signature\Signature', 'getCanonicalizedQueryString');
        $method->setAccessible(true);
        // Create a request and replace the headers with the test headers
        $request = new Request('GET', 'http://www.example.com');
        $request->getQuery()->replace($headers);
        $signature = $this->getMockBuilder('Usabilla\Api\Signature\Signature')
            ->getMockForAbstractClass();
        $this->assertEquals($string, $method->invoke($signature, $request));
    }

    public function testSignsRequestsWithContentHashCorrectly()
    {
        $request = $this->createRequest();
        $contentHash = hash('sha256', 'foobar');
        $request->setHeader('x-usbl-content-sha256', $contentHash);
        $this->signature->signRequest($request, DEFAULT_KEY, DEFAULT_SECRET);
        $context = $request->getQuery()->get('usbl.signature');
        $this->assertNull($context);
    }

    private function createRequest()
    {
        return new Request('GET', 'https://data.usabilla.com', [
            'x-usbl-date' => 'Mon, 09 Sep 2011 23:36:00 GMT',
            'Host' => 'foo.com'
        ]);
    }
}