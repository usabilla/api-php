<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Usabilla\API\Client\UsabillaClient;

if ($argc !== 4) {
    die('Usage: ' . basename(__FILE__) . ' [command] [access-key] [secret-key]' . PHP_EOL);
}

list($commandName, $accessKey, $secretKey) = array_slice($argv, 1);

$client = new UsabillaClient($accessKey, $secretKey);
$command = $client->getCommand($commandName);
$items = $client->execute($command);
print_r($items);