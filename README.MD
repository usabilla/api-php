# Usabilla PHP Client

[![Build Status](https://travis-ci.org/usabilla/api-php.svg?branch=master)](https://travis-ci.org/usabilla/api-php)

This package allows PHP developers to gain access to the Usabilla resources such as buttons, feedback items, campaigns and their results. This packages is heavily inspired by the [AWS PHP Client].

## Resources
* [API Documentation][docs-guide] – For in-depth getting started and usage information.

## Features

* Built for PHP 5.4.3+ and is compliant with [PSR-4][PSR-4].
* Built on [Guzzle v3][guzzle]
* Installable through composer


## Getting Started

1. **Request Usabilla API credentials**
2. Run composer


## Quick Example

### Request 5 feedback items belonging to a button

```php
<?php

require 'vendor/autoload.php';

use Usabilla\API\Client\Client;
use Usabilla\API\Credentials\Credentials;
use Guzzle\Plugin\ErrorResponse\ErrorResponsePlugin;

$credentials = new Credentials("CLIENT-API-KEY", "CLIENT-SECRET-KEY");

/** @var $client Client * */
$client = Client::factory(array(
    "credentials" => $credentials,
));


// specifiy the paramteres as mentioned in the service description
$params = ['id' => '1A2B3C4D5E6F', 'limit' => 5];


/* @var $command Guzzle\Service\Command\AbstractCommand */
$command = $client->getCommand('GetWebsiteFeedbackItems', $params);
/* @var $response Guzzle\Http\Message\Response */
$response = $client->execute($command);

// Convert response to JSON
print_r($response->json());

?>
```


### More Examples

* [Feedback item iterator][example-feedback-iterator]
* [Retrieve all buttons belonging to the account][example-all-buttons]
[AWS PHP Client]: https://github.com/aws/aws-sdk-php
[symfony2-events]: http://symfony.com/doc/2.3/components/event_dispatcher/introduction.html
[guzzle]: https://github.com/guzzle/guzzle3
[PSR-4]: http://www.php-fig.org/psr/psr-4/
[example-feedback-iterator]: https://github.com/usabilla/api-php/tree/master/examples/FeedbackIterator.php
[example-all-buttons]: https://github.com/usabilla/api-php/tree/master/examples/Buttons.php
[docs-guide]: https://usabilla.com/api
