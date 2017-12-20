<?php

require_once(__DIR__ . '/autoload.php');

use Usabilla\API\Client\UsabillaClient;

if ($argc !== 5) {
    die('Usage: ' . basename(__FILE__) . ' [command] [id] [access-key] [secret-key]' . PHP_EOL);
}

list($commandName, $id, $accessKey, $secretKey) = array_slice($argv, 1);

$client = new UsabillaClient($accessKey, $secretKey);
$command = $client->getCommand($commandName, ['id' => $id]);
$items = $client->execute($command);
print_r($items);
