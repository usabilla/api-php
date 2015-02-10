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

namespace Usabilla\API\Client;


use Guzzle\Service\Command\Factory\AliasFactory;
use Guzzle\Service\Command\Factory\CompositeFactory;
use Usabilla\API\Client\ClientOptions as Options;

use Guzzle\Service\Client as GuzzleServiceClient;

use Usabilla\API\Signature\SignatureListener;
use Usabilla\API\Credentials\Credentials;
use Usabilla\API\Signature\Signature;
use Guzzle\Service\Resource\Model;

use Guzzle\Common\Collection;
use Guzzle\Service\Command;

/**
 *
 * @method Model getFeedbackItems(array $args = array()) {
 * @command Client GetFeedbackItems
 * }
 * @method Model getButtons(array $args = array()) {
 * @command Client GetButtons
 * }
 * @method Model getCampaigns(array $args = array()) {
 * @command Client GetCampaigns
 * }
 * @method Model getCampaignResult(array $args = array()) {
 * @command Client GetCampaignResult
 * }
 */
class Client extends GuzzleServiceClient implements ClientInterface
{

    /**
     * @var Credentials credentials used to sign the request
     */
    protected $credentials;
    /**
     * @var Signature Signature implementation of the service
     */
    protected $signature;


    /**
     * @var array Aliases for Usabilla operations
     */
    protected static $commandAliases = array(
        'GetFeedbackItems' => 'FeedbackItems',
    );


    public static function factory($config = array())
    {
        // Specify the directory of the service description array
        $config['service.description'] = __DIR__ . '/../../src/Resources/ServiceDescriptor.php';

        $client = ClientBuilder::factory()
            ->setConfig($config)
            ->setConfigDefaults(array(Options::SCHEME => 'https'))
            ->setConfigRequirements(array('scheme'))
            ->build();

        $default = CompositeFactory::getDefaultChain($client);
        $default->add(
            new AliasFactory($client, static::$commandAliases),
            'Guzzle\Service\Command\Factory\ServiceDescriptionFactory'
        );

        // Load commands (magic)
        $client->setCommandFactory($default);

        return $client;
    }


    /**
     * @param Credentials $credentials credentials
     * @param Signature $signature Signature implementation
     * @param Collection $config Configuration options
     */
    public function __construct(Credentials $credentials, Signature $signature, Collection $config)
    {
        // Bootstrap with Guzzle
        parent::__construct($config->get(Options::BASE_URL), $config);
        $this->credentials = $credentials;
        $this->signature = $signature;

        // Add the listener to create signed requests
        $dispatcher = $this->getEventDispatcher();
        $dispatcher->addSubscriber(new SignatureListener($credentials, $signature));
    }


    public function getCredentials()
    {
        return $this->credentials;
    }

    public function setCredentials(Credentials $credentials)
    {
        $formerCredentials = $this->credentials;
        $this->credentials = $credentials;
        // Dispatch an event that the credentials have been changed
        $this->dispatch('client.credentials_changed', array(
            'credentials' => $credentials,
            'former_credentials' => $formerCredentials,
        ));
        return $this;
    }

    public function getSignature()
    {
        return $this->signature;
    }

}