# Usabilla PHP Client

[![Build Status](https://travis-ci.org/usabilla/api-php.svg?branch=master)](https://travis-ci.org/usabilla/api-php) [![Code Climate](https://codeclimate.com/github/usabilla/api-php/badges/gpa.svg)](https://codeclimate.com/github/usabilla/api-php) [![Test Coverage](https://codeclimate.com/github/usabilla/api-php/badges/coverage.svg)](https://codeclimate.com/github/usabilla/api-php)

This package allows PHP developers to gain access to the Usabilla resources such as buttons, feedback items, campaigns and their results. This packages is heavily inspired by the [AWS PHP Client](https://github.com/aws/aws-sdk-php).

## Resources

* [API Documentation](https://usabilla.com/api) – For in-depth getting started and usage information.

## Features

* Built for PHP 5.4.3+ and compliant with [PSR-4](http://www.php-fig.org/psr/psr-4/).
* Built on [Guzzle](https://github.com/guzzle/guzzle3).
* Installable through Composer.

## Getting Started

1. [Request Usabilla API credentials](https://app.usabilla.com/member/account/settings#public_api).
2. Run `composer require usabilla/usabilla-api-php`.

## Quick Example

### Request 5 feedback items belonging to a button.

```php
<?php

require 'vendor/autoload.php';

use Usabilla\API\Client\Client;
use Usabilla\API\Credentials\Credentials;
use Guzzle\Plugin\ErrorResponse\ErrorResponsePlugin;

$credentials = new Credentials("CLIENT-API-KEY", "CLIENT-SECRET-KEY");

/** @var $client Client */
$client = Client::factory([
    'credentials' => $credentials,
]);

// Specify the parameters as mentioned in the service description.
$params = ['id' => '1A2B3C4D5E6F', 'limit' => 5];

/* @var $command Guzzle\Service\Command\AbstractCommand */
$command = $client->getCommand('GetWebsiteFeedbackItems', $params);

/* @var $response Guzzle\Http\Message\Response */
$response = $client->execute($command);

// Convert response to JSON
print_r($response->json());
```

### More Examples

* [Feedback item iterator](https://github.com/usabilla/api-php/tree/master/examples/FeedbackIterator.php)
* [Retrieve all buttons belonging to the account](https://github.com/usabilla/api-php/tree/master/examples/Buttons.php)
