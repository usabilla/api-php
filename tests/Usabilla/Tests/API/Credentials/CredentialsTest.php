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

namespace Usabilla\Tests\API\Credentials;

use Usabilla\API\Credentials\Credentials;
use Guzzle\Cache\DoctrineCacheAdapter;


class CredentialsTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @covers Usabilla\API\Credentials\Credentials::__construct
     * @covers Usabilla\API\Credentials\Credentials::getAccessKeyId
     * @covers Usabilla\API\Credentials\Credentials::getSecretKey
     */
    public function testOwnsCredentials()
    {
        $c = new Credentials('abc', '123');
        $this->assertEquals('abc', $c->getAccessKeyId());
        $this->assertEquals('123', $c->getSecretKey());
    }

    /**
     * @covers Usabilla\API\Credentials\Credentials::serialize
     * @covers Usabilla\API\Credentials\Credentials::unserialize
     */
    public function testCredentialsCanBeSerialized()
    {
        $c = new Credentials('a', 'b');

        $json = json_decode($c->serialize(), true);
        $this->assertEquals('a', $json['key']);
        $this->assertEquals('b', $json['secret']);

        $c2 = clone $c;
        $c2->unserialize($c->serialize());
        $this->assertEquals('a', $c2->getAccessKeyId());
        $this->assertEquals('b', $c2->getSecretKey());
    }


    public function testSetAccessKey()
    {

        $c = new Credentials('a', 'b');
        $c->setAccessKeyId('a1');

        $this->assertEquals('a1', $c->getAccessKeyId());


    }

    public function testSetSecretKey()
    {
        $c = new Credentials('a', 'b');
        $c->setSecretKey('b1');

        $this->assertEquals('b1', $c->getSecretKey());
    }
}