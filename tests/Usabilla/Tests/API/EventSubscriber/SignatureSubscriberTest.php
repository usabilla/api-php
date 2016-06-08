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

namespace Usabilla\Tests\API\EventSubscriber;

use GuzzleHttp\Client;
use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Transaction;
use Usabilla\API\EventSubscriber\SignatureSubscriber;
use Usabilla\API\Signature\Signature;

class SignatureSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /** @var SignatureSubscriber */
    private $subscriber;

    public function setUp()
    {
        $this->subscriber = new SignatureSubscriber(new Signature(), DEFAULT_KEY, DEFAULT_SECRET);
    }

    public function testGetEvents()
    {
        return [
            'before' => ['onBefore', -255],
        ];
    }

    public function testOnBefore()
    {
        $event = new BeforeEvent(new Transaction(new Client(), new Request('GET', 'https://data.usabilla.com')));
        $this->subscriber->onBefore($event);

        $this->assertEquals(['Host', 'Date', 'Authorization'], array_keys($event->getRequest()->getHeaders()));
    }
}