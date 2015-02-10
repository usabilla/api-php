<?php

/**
 * Copyright 2009-2014 Usabilla.com. All Rights Reserved.
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

use Usabilla\API\Credentials\Credentials;
use Usabilla\API\Signature\Signature;
use Guzzle\Http\Message\RequestFactory;
use Guzzle\Http\Message\Request;

class SignatureTest extends \PHPUnit_Framework_TestCase
{

    const DEFAULT_DATETIME = 'Mon, 09 Sep 2011 23:36:00 GMT';

    const ISO8601    = 'Ymd\THis\Z';
    const ISO8601_S3 = 'Y-m-d\TH:i:s\Z';
    const RFC1123    = 'D, d M Y H:i:s \G\M\T';
    const RFC2822    = \DateTime::RFC2822;
    const SHORT      = 'Ymd';

    /**
     * @return Signature
     */
    private function getSignature()
    {
        // Mock the timestamp function to use the test suite timestamp
        $signature = $this->getMock('Usabilla\API\Signature\Signature', array('getTimestamp', 'getDateTime'));

        // Hack the shared timestamp
        $signature->expects($this->any())
            ->method('getTimestamp')
            ->will($this->returnValue(strtotime(self::DEFAULT_DATETIME)));

        // Hack the date time to deal with the wrong date in the example files
        $signature->expects($this->any())
            ->method('getDateTime')
            ->will($this->returnValueMap(array(
                array(self::RFC1123, 'Mon, 09 Sep 2011 23:36:00 GMT'),
                array(self::ISO8601, '20110909T233600Z'),
                array(self::SHORT, '20110909')
            )));

        return $signature;
    }



    /**
     * @covers Usabilla\API\Signature\Signature::signRequest
     */
    public function testSignsRequests()
    {
        $credentials = new Credentials(DEFAULT_KEY, DEFAULT_SECRET);
        $signature = $this->getSignature();
        $request = RequestFactory::getInstance()->fromMessage("GET / HTTP/1.1\r\nx-usbl-date: Mon, 09 Sep 2011 23:36:00 GMT\r\nHost: foo.com\r\n\r\n");

        $contentHash = hash('sha256', 'foobar');
        $request->setHeader('x-usbl-content-sha256', $contentHash);

        $signature->signRequest($request, $credentials);
    }

    /**
     * @covers Usabilla\API\Signature\Signature::getPayload
     */
    public function testRequestDefaultPayload()
    {
        $credentials = new Credentials(DEFAULT_KEY, DEFAULT_SECRET);
        $signature = $this->getSignature();
        $request = RequestFactory::getInstance()->fromMessage("GET / HTTP/1.1\r\nx-usbl-date: Mon, 09 Sep 2011 23:36:00 GMT\r\nHost: foo.com\r\n\r\n");

        $signature->signRequest($request, $credentials);
    }

    public function queryStringProvider()
    {
        return array(
            array(array(
                'Foo' => '',
                'a' => 0,
            ), 'Foo=&a=0'),
            array(array(
                'Foo' => '',
                'a' => '_guzzle_blank_',
            ), 'Foo=&a='),
            array(array(), ''),
            array(array(
                'X-Usbl-Signature' => 'foo'
            ), ''),
            array(array(
                'Foo' => '123',
                'Bar' => '456'
            ), 'Bar=456&Foo=123'),
            array(array(
                'Foo' => array('b', 'a'),
                'a' => 'bc'
            ), 'Foo=a&Foo=b&a=bc'),
            array(array(
                'Foo' => '',
                'a' => 'b'
            ), 'Foo=&a=b')
        );
    }

    /**
     * @covers Usabilla\API\Signature\Signature::getCanonicalizedQueryString
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


    /**
     * @covers Usabilla\API\Signature\Signature::generateSignature
     */
    public function testGenerateSignature()
    {
        $signature = $this->getSignature();
        $signature->generateSignature(DEFAULT_SECRET, array("key" => "value"));
    }


    /**
     * @covers Usabilla\API\Signature\Signature::signRequest
     * @covers Usabilla\API\Signature\Signature::createSigningContext
     * @covers Usabilla\API\Signature\Signature::getSigningKey
     */
    public function testSignsRequestsWithContentHashCorrectly()
    {
        $credentials = new Credentials(DEFAULT_KEY, DEFAULT_SECRET);
        $signature = $this->getSignature();
        $request = RequestFactory::getInstance()->fromMessage("GET / HTTP/1.1\r\nx-usbl-date: Mon, 09 Sep 2011 23:36:00 GMT\r\nHost: foo.com\r\n\r\n");
        $contentHash = hash('sha256', 'foobar');
        $request->setHeader('x-usbl-content-sha256', $contentHash);
        $signature->signRequest($request, $credentials);
        $context = $request->getParams()->get('usbl.signature');
        $this->assertContains($contentHash, $context['canonical_request']);
    }

}