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

/**
 * Guzzle allows you to serialize HTTP requests and parse HTTP responses using a DSL called a service descriptions.
 * Service descriptions define web service APIs by documenting each operation, the operation's parameters,
 * validation options for each parameter, an operation's response, how the response is parsed, and any errors that can be raised for an operation.
 * Writing a service description for a web service allows you to more quickly consume a web service than writing concrete commands for each web service operation.
 * Guzzle service descriptions can be representing using a PHP array or JSON document. Guzzle's service descriptions are heavily inspired by Swagger.
 * source http://guzzle3.readthedocs.org/webservice-client/guzzle-service-descriptions.html
 */

namespace Usabilla\API\Resources;

return [
    'baseUrl' => 'https://data.usabilla.com',
    'apiVersion' => '1.0',
    'operations' => [
        'GetCampaigns' => [
            'httpMethod' => 'GET',
            'uri' => '/live/website/campaign',
            'responseModel' => 'CampaignItems',
            'parameters' => [
                'since' => [
                    'type' => 'integer',
                    'location' => 'query'
                ],
                'limit' => [
                    'type' => 'integer',
                    'location' => 'query'
                ],
            ],
        ],
        'GetCampaignResults' => [
            'httpMethod' => 'GET',
            'uri' => '/live/website/campaign/{id}/results',
            'responseModel' => 'CampaignResultItems',
            'parameters' => [
                'id' => [
                    'type' => 'string',
                    'location' => 'uri'
                ],
                'since' => [
                    'type' => 'integer',
                    'location' => 'query'
                ],
                'limit' => [
                    'type' => 'integer',
                    'location' => 'query'
                ],
            ],
        ],
        'GetButtons' => [
            'httpMethod' => 'GET',
            'uri' => '/live/website/button',
            'responseModel' => 'ButtonItems',
            'parameters' => [
                'limit' => [
                    'type' => 'integer',
                    'location' => 'query'
                ],
            ],
        ],
        'GetFeedbackItems' => [
            'httpMethod' => 'GET',
            'uri' => '/live/website/button/{id}/feedback',
            'responseModel' => 'FeedbackItems',
            'parameters' => [
                'id' => [
                    'type' => 'string',
                    'location' => 'uri',
                    'default' => '*'
                ],
                'since' => [
                    'type' => 'integer',
                    'location' => 'query'
                ],
                'limit' => [
                    'type' => 'integer',
                    'location' => 'query'
                ],
            ],
        ],
    ],
    'models' => [
        'FeedbackItem' => [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'userAgent' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'comment' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'location' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'date' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'custom' => [
                    'location' => 'json',
                    'type' => 'array'
                ],
                'email' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'html_snippet' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'image' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'labels' => [
                    'location' => 'json',
                    'type' => 'array'
                ],
                'nps' => [
                    'location' => 'json',
                    'type' => 'integer'
                ],
                'publicUrl' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'rating' => [
                    'location' => 'json',
                    'type' => 'integer'
                ],
                'buttonId' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'tags' => [
                    'location' => 'json',
                    'type' => 'array'
                ],
                'url' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
            ],
        ],
        'FeedbackItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'FeedbackItem'
            ],
        ],
        'ButtonItem' => [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'name' => [
                    'location' => 'json',
                    'type' => 'string'
                ]
            ],
        ],
        'ButtonItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'ButtonItem'
            ],
            "errorResponses" => [
                [
                    "code" => "403",
                    "phrase" => "authorisation failed",
                    "class" => "ClientErrorResponseException"
                ]
            ],
        ],
        'CampaignItem' => [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'buttonId' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'analyticsId' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'date' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'status' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'name' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
            ],
        ],
        'CampaignItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'CampaignItem'
            ],
            "errorResponses" => [
                [
                    "code" => "403",
                    "phrase" => "authorisation failed",
                    "class" => "ClientErrorResponseException"
                ]
            ],
        ],
        'CampaignResultItem' => [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'campaignId' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'date' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'userAgent' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'custom' => [
                    'location' => 'json',
                    'type' => 'array'
                ],
                'data' => [
                    'location' => 'json',
                    'type' => 'array'
                ],
                'time' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'location' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
            ],
        ],
        'CampaignResultItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'CampaignResultItem'
            ],
            "errorResponses" => [
                [
                    "code" => "403",
                    "phrase" => "authorisation failed",
                    "class" => "ClientErrorResponseException"
                ]
            ],
        ],
    ],
];