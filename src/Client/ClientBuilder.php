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

use Usabilla\API\Exception\InvalidArgumentException;
use Usabilla\API\Client\ClientOptions as Options;
use Usabilla\API\Signature\Signature;
use Guzzle\Common\Collection;
use Guzzle\Service\Description\ServiceDescription;

/**
 * Builder for creating service clients
 */
class ClientBuilder
{
    /**
     * @var array Default client config
     */
    protected static $commonConfigDefaults = array('scheme' => 'https');

    /**
     * @var array Default client requirements
     */
    protected static $commonConfigRequirements = array(Options::SERVICE_DESCRIPTION);

    /**
     * @var string The namespace of the client
     */
    protected $clientNamespace;

    /**
     * @var array The config options
     */
    protected $config = array();

    /**
     * @var array The config defaults
     */
    protected $configDefaults = array();

    /**
     * @var array The config requirements
     */
    protected $configRequirements = array();


    /**
     * @var array Array of configuration data for iterators available for the client
     */
    protected $iteratorsConfig = array();

    /**
     * Factory method for creating the client builder
     *
     * @param string $namespace The namespace of the client
     *
     * @return ClientBuilder
     */
    public static function factory($namespace = null)
    {
        return new static($namespace);
    }

    /**
     * Constructs a client builder
     *
     * @param string $namespace The namespace of the client
     */
    public function __construct($namespace = null)
    {
        $this->clientNamespace = $namespace;
    }

    /**
     * Sets the config options
     *
     * @param array|Collection $config The config options
     *
     * @return ClientBuilder
     */
    public function setConfig($config)
    {
        $this->config = $this->processArray($config);

        return $this;
    }

    /**
     * Sets the config options' defaults
     *
     * @param array|Collection $defaults The default values
     *
     * @return ClientBuilder
     */
    public function setConfigDefaults($defaults)
    {
        $this->configDefaults = $this->processArray($defaults);

        return $this;
    }

    /**
     * Sets the required config options
     *
     * @param array|Collection $required The required config options
     *
     * @return ClientBuilder
     */
    public function setConfigRequirements($required)
    {
        $this->configRequirements = $this->processArray($required);

        return $this;
    }


    /**
     * Performs the building logic using all of the parameters that have been
     * set and falling back to default values. Returns an instantiate service
     * client with credentials prepared and plugins attached.
     *
     * @return ClientInterface
     * @throws InvalidArgumentException
     */
    public function build()
    {
        // Resolve configuration
        $config = Collection::fromConfig(
            $this->config,
            array_merge(self::$commonConfigDefaults, $this->configDefaults),
            (self::$commonConfigRequirements + $this->configRequirements)
        );


        // Resolve the endpoint, signature, and credentials
        $description = $this->updateConfigFromDescription($config);
        $signature = $this->getSignature();
        $credentials = $this->getCredentials($config);

        // Determine service and class name
        $clientClass = 'Usabilla\API\Client\Client';

        /** @var $client ClientInterface */
        $client = new $clientClass($credentials, $signature, $config);
        $client->setDescription($description);


        return $client;
    }


    /**
     * Ensures that an array (e.g. for config data) is actually in array form
     *
     * @param array|Collection $array The array data
     *
     * @return array
     * @throws InvalidArgumentException if the arg is not an array or Collection
     */
    protected function processArray($array)
    {
        if (!is_array($array)) {
            throw new InvalidArgumentException('The config must be provided as an array or Collection.');
        }

        return $array;
    }

    /**
     * Update a configuration object from a service description
     *
     * @param Collection $config Config to update
     *
     * @return ServiceDescription
     * @throws InvalidArgumentException
     */
    protected function updateConfigFromDescription(Collection $config)
    {
        $description = $config->get(Options::SERVICE_DESCRIPTION);
        if (!($description instanceof ServiceDescription)) {
            // Inject the version into the sprintf template if it is a string
            if (is_string($description)) {
                $description = sprintf($description, $config->get(Options::VERSION));
            }
            $description = ServiceDescription::factory($description);
            $config->set(Options::SERVICE_DESCRIPTION, $description);
        }

        return $description;
    }

    /**
     * Return an appropriate signature object for a a client based on the
     * "signature" configuration setting, or the default signature specified in
     * a service description. The signature can be set to a valid signature
     * version identifier string or an instance of Usabilla\API\Signature\Signature.
     *
     * @return Signature
     * @throws InvalidArgumentException
     */
    protected function getSignature()
    {
        /** @var Signature $signature */
        $signature = new Signature();

        return $signature;
    }

    protected function getCredentials(Collection $config)
    {
        $credentials = $config->get(Options::CREDENTIALS);

        return $credentials;
    }
}