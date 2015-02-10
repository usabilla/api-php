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

namespace Usabilla\Tests\API\Client;


use Usabilla\API\Client\Client;
use Usabilla\API\Credentials\Credentials;
use PHPUnit_Framework_TestCase;
use Guzzle\Common\Exception\InvalidArgumentException;

class CommandsTest extends PHPUnit_Framework_TestCase
{


    /**
     * @covers Usabilla\API\Client\Client::factory
     */
    public function testDefaultClient()
    {
        date_default_timezone_set('Europe/Amsterdam');
        $credentials = new Credentials(DEFAULT_KEY, DEFAULT_SECRET);

        $client = Client::factory(array(
            "credentials" => $credentials,
        ));

        $this->assertInstanceOf('Usabilla\API\Signature\Signature', $client->getSignature());
        $this->assertInstanceOf('Usabilla\API\Credentials\Credentials', $client->getCredentials());
        $this->assertSame($credentials, $client->getCredentials());
        $this->assertEquals(baseURL, $client->getBaseUrl());
    }

    /**
     * @covers Usabilla\API\Client\Client::setConfig
     */
    public function testClientConfigException()
    {
        $credentials = new Credentials(DEFAULT_KEY, DEFAULT_SECRET);

        try {
            $client = Client::factory(array(
                "credentials" => $credentials,
            ));

            $client->setConfig("");
        } catch (InvalidArgumentException $e) {
            $returnValue = null;
        }

        $this->assertNull($returnValue);
    }
}











