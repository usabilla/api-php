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


use Guzzle\Service\Description\ServiceDescription;
use Usabilla\API\Client\Client;
use Usabilla\API\Credentials\Credentials;
use PHPUnit_Framework_TestCase;
use Guzzle\Service\Description\Operation;


class ClientTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Credentials Usabilla credentials
     */
    protected $credentials;


    /**
     * @var Client Usabilla client
     */
    protected $client;

    /**
     * @var ServiceDescription Usabilla Service description
     */
    protected $description;


    /**
     * @var Operation Usabilla command
     */
    protected $operation;


    protected function setUp()
    {
        date_default_timezone_set('Europe/Amsterdam');
        $this->credentials = new Credentials(DEFAULT_KEY, DEFAULT_SECRET);


        $this->client = Client::factory(array(
            "credentials" => $this->credentials,
        ));
    }

    public function assertQueryParametersAreEqual($request, $filter)
    {
        foreach ($request->getQuery() as $key => $value) {
            $this->assertEquals($filter[$key], $value);
        }
    }

    public function testButtons()
    {
        $command = $this->client->getCommand('GetButtons');
        $request = $command->prepare();

        $this->assertEquals($request->getUrl(), baseURL . '/live/website/button');
        $this->assertEmpty($request->getQuery());

        $filter = ['limit' => 1, 'since' => 1416845584];
        $command = $this->client->getCommand('GetButtons', $filter);
        $request = $command->prepare();
        $this->assertNotEmpty($request->getQuery());
    }


    public function testGetFeedbackItems()
    {
        $command = $this->client->getCommand('GetFeedbackItems');
        $request = $command->prepare();
        $this->assertEquals($request->getUrl(), baseURL . '/live/website/button/%2A/feedback');

        $filter = ['id' => '123ABC456'];
        $command = $this->client->getCommand('GetFeedbackItems', $filter);
        $request = $command->prepare();
        $this->assertEquals($request->getUrl(), baseURL . '/live/website/button/' . $filter['id'] . '/feedback');

        $filter = ['id' => '123ABC456', 'limit' => 1, 'since' => 1416845584];
        $command = $this->client->getCommand('GetFeedbackItems', $filter);
        $request = $command->prepare();
        $this->assertNotEmpty($request->getQuery());
        $this->assertQueryParametersAreEqual($request, $filter);
    }


    public function testGetCampaigns()
    {
        $command = $this->client->getCommand('GetCampaigns');
        $request = $command->prepare();
        $this->assertEquals($request->getUrl(), baseURL . '/live/website/campaign');
        $this->assertEmpty($request->getQuery());

        $filter = ['id' => '123ABC456', 'limit' => 1, 'since' => 1416845584];
        $command = $this->client->getCommand('GetCampaigns', $filter);
        $request = $command->prepare();
        $this->assertNotEmpty($request->getQuery());
        $this->assertQueryParametersAreEqual($request, $filter);
    }

    public function testGetCampaignResults()
    {
        $command = $this->client->getCommand('GetCampaignResults');
        $request = $command->prepare();
        $this->assertNotEquals($request->getUrl(), baseURL . '/live/website/campaign/%2A/feedback');

        $filter = ['id' => '123ABC456'];
        $command = $this->client->getCommand('GetCampaignResults', $filter);
        $request = $command->prepare();
        $this->assertEquals($request->getUrl(), baseURL . '/live/website/campaign/' . $filter['id'] . '/results');

        $filter = ['id' => '123ABC456', 'limit' => 1, 'since' => 1416845584];
        $command = $this->client->getCommand('GetCampaignResults', $filter);
        $request = $command->prepare();
        $this->assertNotEmpty($request->getQuery());
        $this->assertQueryParametersAreEqual($request, $filter);
    }

}











