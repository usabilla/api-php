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

require '../vendor/autoload.php';

use Usabilla\API\Client\Client;
use Usabilla\API\Credentials\Credentials;
use Guzzle\Plugin\ErrorResponse\ErrorResponsePlugin;

$credentials = new Credentials("CLIENT-API-KEY", "CLIENT-SECRET-KEY");

/** @var $client Client * */
$client = Client::factory(array(
    "credentials" => $credentials,
));



/* @var $command Guzzle\Service\Command\AbstractCommand */
$command = $client->getCommand('GetButtons');
/* @var $response Guzzle\Http\Message\Response */
$response = $client->execute($command);


// Alternatively we can call and execute functions by their name
// as specified in the service description

/* @var $response Guzzle\Http\Message\Response */
//$response = $client->getFeedbackItems();

// Convert response to JSON
print_r($response);

?>