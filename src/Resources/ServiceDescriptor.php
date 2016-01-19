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
    'apiVersion' => '1.2',
    'operations' => [
        'GetInpageWidgets' => [
            'httpMethod' => 'GET',
            'uri' => '/live/websites/inpage',
            'responseModel' => 'InpageWidgetItems',
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
        'GetInpageWidgetFeedbackItems' => [
            'httpMethod' => 'GET',
            'uri' => '/live/websites/inpage/{id}/feedback',
            'responseModel' => 'InpageWidgetFeedbackItems',
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
        'GetWebsiteCampaigns' => [
            'httpMethod' => 'GET',
            'uri' => '/live/websites/campaign',
            'responseModel' => 'WebsiteCampaignItems',
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
        'GetWebsiteCampaignResults' => [
            'httpMethod' => 'GET',
            'uri' => '/live/websites/campaign/{id}/results',
            'responseModel' => 'WebsiteCampaignResultItems',
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
        'GetWebsiteCampaignStats' => [
            'httpMethod' => 'GET',
            'uri' => '/live/websites/campaign/{id}/stats',
            'responseModel' => 'WebsiteCampaignStatsItems',
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
        'GetWebsiteButtons' => [
            'httpMethod' => 'GET',
            'uri' => '/live/websites/button',
            'responseModel' => 'WebsiteButtonItems',
        ],
        'GetEmailButtons' => [
            'httpMethod' => 'GET',
            'uri' => '/live/email/button',
            'responseModel' => 'EmailButtonItems',
        ],
        'GetApps' => [
            'httpMethod' => 'GET',
            'uri' => '/live/apps',
            'responseModel' => 'AppItems',
        ],
        'GetWebsiteFeedbackItems' => [
            'httpMethod' => 'GET',
            'uri' => '/live/websites/button/{id}/feedback',
            'responseModel' => 'WebsiteFeedbackItems',
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
        'GetEmailFeedbackItems' => [
            'httpMethod' => 'GET',
            'uri' => '/live/email/button/{id}/feedback',
            'responseModel' => 'EmailFeedbackItems',
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
        'GetAppFeedbackItems' => [
            'httpMethod' => 'GET',
            'uri' => '/live/apps/{id}/feedback',
            'responseModel' => 'AppFeedbackItems',
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
        'WebsiteFeedbackItem' => [
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
        'WebsiteFeedbackItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'WebsiteFeedbackItem'
            ],
        ],
        'EmailFeedbackItem' => [
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
        'EmailFeedbackItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'EmailFeedbackItem'
            ],
        ],
        'AppFeedbackItem' => [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'date' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'timestamp' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'deviceName' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'data' => [
                    'location' => 'json',
                    'type' => 'array'
                ],
                'custom' => [
                    'location' => 'json',
                    'type' => 'array'
                ],
                'appId' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'appName' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'appVersion' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'osName' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'osVersion' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'location' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'geoLocation' => [
                    'location' => 'json',
                    'type' => 'array'
                ],
                'freeMemory' => [
                    'location' => 'json',
                    'type' => 'integer'
                ],
                'totalMemory' => [
                    'location' => 'json',
                    'type' => 'integer'
                ],
                'freeStorage' => [
                    'location' => 'json',
                    'type' => 'integer'
                ],
                'totalStorage' => [
                    'location' => 'json',
                    'type' => 'integer'
                ],
                'screenshot' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'screensize' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'connection' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'ipAddress' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'language' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'orientation' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'batteryLevel' => [
                    'location' => 'json',
                    'type' => 'numeric'
                ],
            ],
        ],
        'AppFeedbackItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'AppFeedbackItem'
            ],
        ],
        'WebsiteButtonItem' => [
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
        'WebsiteButtonItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'WebsiteButtonItem'
            ],
            "errorResponses" => [
                [
                    "code" => "403",
                    "phrase" => "authorisation failed",
                    "class" => "ClientErrorResponseException"
                ]
            ],
        ],
        'EmailButtonItem' => [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'name' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'date' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'introText' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'locale' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'groups' => [
                    'location' => 'json',
                    'type' => 'array'
                ],
            ],
        ],
        'EmailButtonItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'EmailButtonItem'
            ],
            "errorResponses" => [
                [
                    "code" => "403",
                    "phrase" => "authorisation failed",
                    "class" => "ClientErrorResponseException"
                ]
            ],
        ],
        'AppItem' => [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'name' => [
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
            ],
        ],
        'AppItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'AppItem'
            ],
            "errorResponses" => [
                [
                    "code" => "403",
                    "phrase" => "authorisation failed",
                    "class" => "ClientErrorResponseException"
                ]
            ],
        ],
        'InpageWidgetItem' => [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'date' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'name' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
            ],
        ],
        'InpageWidgetItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'InpageWidgetItem'
            ],
            "errorResponses" => [
                [
                    "code" => "403",
                    "phrase" => "authorisation failed",
                    "class" => "ClientErrorResponseException"
                ]
            ],
        ],
        'InpageWidgetFeedbackItem' => [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'widgetId' => [
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
                'customData' => [
                    'location' => 'json',
                    'type' => 'array'
                ],
                'data' => [
                    'location' => 'json',
                    'type' => 'array'
                ],
                'geo' => [
                    'location' => 'json',
                    'type' => 'array'
                ],
                'url' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'rating' => [
                    'location' => 'json',
                    'type' => 'numeric'
                ],
                'comment' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'mood' => [
                    'location' => 'json',
                    'type' => 'numeric'
                ],
                'nps' => [
                    'location' => 'json',
                    'type' => 'integer'
                ],
            ],
        ],
        'WebsiteCampaignItem' => [
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
        'WebsiteCampaignItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'WebsiteCampaignItem'
            ],
            "errorResponses" => [
                [
                    "code" => "403",
                    "phrase" => "authorisation failed",
                    "class" => "ClientErrorResponseException"
                ]
            ],
        ],
        'WebsiteCampaignResultItem' => [
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
        'WebsiteCampaignStatsItem' => [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'location' => 'json',
                    'type' => 'string'
                ],
                'completed' => [
                    'location' => 'json',
                    'type' => 'integer'
                ],
                'views' => [
                    'location' => 'json',
                    'type' => 'integer'
                ],
                'conversion' => [
                    'location' => 'json',
                    'type' => 'integer'
                ],
            ],
        ],
        'WebsiteCampaignStatsItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'WebsiteCampaignStatsItem'
            ],
            "errorResponses" => [
                [
                    "code" => "403",
                    "phrase" => "authorisation failed",
                    "class" => "ClientErrorResponseException"
                ]
            ],
        ],
        'WebsiteCampaignResultItems' => [
            'type' => 'array',
            'items' => [
                '$ref' => 'WebsiteCampaignResultItem'
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