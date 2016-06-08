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

use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Usabilla\API\Description\UsabillaDescription;
use Usabilla\API\EventSubscriber\SignatureSubscriber;
use Usabilla\API\Signature\Signature;

/**
 * Class UsabillaClient
 *
 * @package Usabilla\API\Client
 */
class UsabillaClient extends GuzzleClient
{
    /**
     * UsabillaClient constructor.
     *
     * @param string $accessKey
     * @param string $secretKey
     * @param array  $config
     */
    public function __construct($accessKey, $secretKey, array $config = [])
    {
        $client = new Client();
        $client->getEmitter()->attach(new SignatureSubscriber(new Signature(), $accessKey, $secretKey));

        $description = new UsabillaDescription();

        parent::__construct($client, $description, $config);
    }

    /**
     * Iterates through a given command.
     * 
     * @param string $commandName
     *
     * @return \Generator
     */
    public function getIterator($commandName)
    {
        $hasMore = true;
        $arguments = [];
        while ($hasMore) {
            $result = $this->execute($this->getCommand($commandName, $arguments));
            foreach ($result['items'] as $item) {
                yield $item;
            }
            $hasMore = $result['hasMore'];
            $arguments['since'] = $result['lastTimestamp'];
        }
    }
}