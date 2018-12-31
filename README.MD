# Usabilla PHP Client

[![Build Status](https://travis-ci.org/usabilla/api-php.svg?branch=master)](https://travis-ci.org/usabilla/api-php) [![Code Climate](https://codeclimate.com/github/usabilla/api-php/badges/gpa.svg)](https://codeclimate.com/github/usabilla/api-php) [![Test Coverage](https://codeclimate.com/github/usabilla/api-php/badges/coverage.svg)](https://codeclimate.com/github/usabilla/api-php)

This package allows PHP developers to gain access to the Usabilla resources such as buttons, feedback items, campaigns and their results. This packages is heavily inspired by the [AWS PHP Client](https://github.com/aws/aws-sdk-php).

## Resources

* [API Documentation](http://developers.usabilla.com) – For in-depth getting started and usage information.

## Features

* Built for PHP 5.6+ and compliant with [PSR-4](http://www.php-fig.org/psr/psr-4/).
* Built on [Guzzle Services](https://github.com/guzzle/guzzle-services).
* Installable through Composer.

## Getting Started
1. Install Composer by following installation instructions on: https://getcomposer.org/download/
2. [Request Usabilla API credentials](https://app.usabilla.com/member/account/settings#public_api).
3. Run `composer require usabilla/usabilla-api-php` on your project.

## Quick Example

### Request 5 feedback items belonging to a button.

```php
<?php

require 'vendor/autoload.php';

use Usabilla\API\Client\UsabillaClient;

// Creates a new Usabilla client.
$client = new UsabillaClient('ACCESS_KEY', 'SECRET_KEY');

// Specify the parameters as mentioned in the service description.
$params = ['id' => 'BUTTON_ID', 'limit' => 5];

// Gets the command.
$command = $client->getCommand('GetWebsiteFeedbackItems', $params);

// Executes the command.
$response = $client->execute($command);

// Prints the received response.
print_r($response);
```

### Using Command Line

You can use the command line to retrieve results from the API using scripts found in the [example folder](examples/):

* Using single_page.php :
`php single_page.php {command} {access-key} {secret-key}`

* Using single_page_with_id.php :
`php single_page_with_id.php {command} {id} {access-key} {secret-key}`

### More examples:

* [Results iterator example](examples/iterator.php)
* [Single results page example](examples/single_page.php)
