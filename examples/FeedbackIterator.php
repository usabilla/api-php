<?php

/**
 * Copyright Usabilla.com. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * https://github.com/usabilla/php-client/LICENSE.MD
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

/**
 * Resource iterators are used to automatically get the newest items
 * The from query parameter is updated with the last item's timestamp
 */

require '../vendor/autoload.php';

use Usabilla\API\Client\Client;
use Usabilla\API\Credentials\Credentials;
use Guzzle\Iterator;

// Set up the Usabilla credentials
$credentials = new Credentials("CLIENT-API-KEY", "CLIENT-SECRET-KEY");

/** @var $client Client **/
$client = Client::factory(array(
    "credentials" => $credentials,
));

// specifiy the paramteres as mentioned in the service description
$params = ['id' => 'a3196e1047e6'];

$iterator = $client->getIterator('GetWebsiteCampaigns', $params);

foreach ($iterator as $feedbackItem) {
   print_r($feedbackItem);
}

?>