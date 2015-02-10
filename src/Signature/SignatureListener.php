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
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


/**
 * Listener used to sign requests before they are sent over the wire
 */
class SignatureListener implements EventSubscriberInterface
{
    /**
     * @var Credentials
     */
    protected $credentials;
    /**
     * @var Signature
     */
    protected $signature;
    /**
     * Construct a new request signing plugin
     *
     * @param Credentials $credentials Credentials used to sign requests
     * @param Signature   $signature   Signature implementation
     */
    public function __construct(Credentials $credentials, Signature $signature)
    {
        $this->credentials = $credentials;
        $this->signature = $signature;
    }
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send'        => array('onRequestBeforeSend', -255),
            'client.credentials_changed' => array('onCredentialsChanged')
        );
    }
    /**
     * Updates the listener with new credentials if the client is updated
     *
     * @param Event $event Event emitted
     */
    public function onCredentialsChanged(Event $event)
    {
        $this->credentials = $event['credentials'];
    }
    /**
     * Signs requests before they are sent
     *
     * @param Event $event Event emitted
     */
    public function onRequestBeforeSend(Event $event)
    {
        $this->signature->signRequest($event['request'], $this->credentials);
    }
}