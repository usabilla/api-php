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

namespace Usabilla\API\EventSubscriber;

use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Event\SubscriberInterface;
use Usabilla\API\Signature\Signature;

/**
 * Listener used to sign requests before they are sent over the wire
 */
class SignatureSubscriber implements SubscriberInterface
{
    /** @var Signature */
    protected $signature;

    /** @var string */
    protected $accessKey;

    /** @var string */
    protected $secretKey;

    /**
     * Construct a new request signing plugin
     *
     * @param Signature $signature Signature implementation
     * @param string    $accessKey
     * @param string    $secretKey
     */
    public function __construct(Signature $signature, $accessKey, $secretKey)
    {
        $this->signature = $signature;
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvents()
    {
        return [
            'before' => ['onBefore', -255],
        ];
    }

    /**
     * Signs requests before they are sent
     *
     * @param BeforeEvent $event Event emitted
     */
    public function onBefore(BeforeEvent $event)
    {
        $this->signature->signRequest($event->getRequest(), $this->accessKey, $this->secretKey);
    }
}