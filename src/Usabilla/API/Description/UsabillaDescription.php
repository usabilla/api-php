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

namespace Usabilla\API\Description;

use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\Operation;

class UsabillaDescription extends Description
{
    /**
     * UsabillaDescription constructor.
     */
    public function __construct()
    {
        parent::__construct([

            // Basic information about the Usabilla API.
            'baseUrl' => 'https://data.usabilla.com',
            'apiVersion' => '1.2',

            // All the operations that can be performed at the Usabilla API.
            'operations' => [

                // Usabilla for Apps.
                'GetApps' => [
                    'httpMethod' => 'GET',
                    'uri' => '/live/apps',
                    'responseModel' => 'AppItems',
                ],

                'GetAppFeedbackItems' => [
                    'httpMethod' => 'GET',
                    'uri' => '/live/apps/{id}/feedback',
                    'responseModel' => 'AppFeedbackItems',
                    'parameters' => [
                        'id' => [ '$ref' => 'NonMandatoryIdParam' ],
                        'limit' => [ '$ref' => 'LimitParam' ],
                        'since' => [ '$ref' => 'SinceParam' ],
                    ],
                ],

                // Usabilla for Email.
                'GetEmailButtons' => [
                    'httpMethod' => 'GET',
                    'uri' => '/live/email/button',
                    'responseModel' => 'EmailButtonItems',
                ],

                'GetEmailFeedbackItems' => [
                    'httpMethod' => 'GET',
                    'uri' => '/live/email/button/{id}/feedback',
                    'responseModel' => 'EmailFeedbackItems',
                    'parameters' => [
                        'id' => [ '$ref' => 'NonMandatoryIdParam' ],
                        'limit' => [ '$ref' => 'LimitParam' ],
                        'since' => [ '$ref' => 'SinceParam' ],
                    ],
                ],

                // Usabilla for Websites.
                'GetInpageWidgets' => [
                    'httpMethod' => 'GET',
                    'uri' => '/live/websites/inpage',
                    'responseModel' => 'InpageWidgetItems',
                    'parameters' => [
                        'limit' => [ '$ref' => 'LimitParam' ],
                        'since' => [ '$ref' => 'SinceParam' ],
                    ],
                ],

                'GetInpageWidgetFeedbackItems' => [
                    'httpMethod' => 'GET',
                    'uri' => '/live/websites/inpage/{id}/feedback',
                    'responseModel' => 'InpageWidgetFeedbackItems',
                    'parameters' => [
                        'id' => [ '$ref' => 'MandatoryIdParam' ],
                        'limit' => [ '$ref' => 'LimitParam' ],
                        'since' => [ '$ref' => 'SinceParam' ],
                    ],
                ],

                'GetWebsiteCampaigns' => [
                    'httpMethod' => 'GET',
                    'uri' => '/live/websites/campaign',
                    'responseModel' => 'WebsiteCampaignItems',
                    'parameters' => [
                        'limit' => [ '$ref' => 'LimitParam' ],
                        'since' => [ '$ref' => 'SinceParam' ],
                    ],
                ],

                'GetWebsiteCampaignResults' => [
                    'httpMethod' => 'GET',
                    'uri' => '/live/websites/campaign/{id}/results',
                    'responseModel' => 'WebsiteCampaignResultItems',
                    'parameters' => [
                        'id' => [ '$ref' => 'MandatoryIdParam' ],
                        'limit' => [ '$ref' => 'LimitParam' ],
                        'since' => [ '$ref' => 'SinceParam' ],
                    ],
                ],

                'GetWebsiteCampaignStats' => [
                    'httpMethod' => 'GET',
                    'uri' => '/live/websites/campaign/{id}/stats',
                    'responseModel' => 'WebsiteCampaignStatsItems',
                    'parameters' => [
                        'id' => [ '$ref' => 'MandatoryIdParam' ],
                        'limit' => [ '$ref' => 'LimitParam' ],
                        'since' => [ '$ref' => 'SinceParam' ],
                    ],
                ],

                'GetWebsiteButtons' => [
                    'httpMethod' => 'GET',
                    'uri' => '/live/websites/button',
                    'responseModel' => 'WebsiteButtonItems',
                ],

                'GetWebsiteFeedbackItems' => [
                    'httpMethod' => 'GET',
                    'uri' => '/live/websites/button/{id}/feedback',
                    'responseModel' => 'WebsiteFeedbackItems',
                    'parameters' => [
                        'id' => [ '$ref' => 'NonMandatoryIdParam' ],
                        'limit' => [ '$ref' => 'LimitParam' ],
                        'since' => [ '$ref' => 'SinceParam' ],
                    ],
                ],
            ],

            'models' => [

                // The main models that can be fetched from the Usabilla API.
                'AppItems' => [
                    'type' => 'object',
                    'properties' => [
                        'count' => [ '$ref' => 'CountAttribute' ],
                        'hasMore' => [ '$ref' => 'HasMoreAttribute' ],
                        'items' => [
                            'location' => 'json',
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
//                                'properties' => [
//                                    'id' => [ '$ref' => 'IdAttribute' ],
//                                    'name' => [ '$ref' => 'NameAttribute' ],
//                                    'date' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'status' => [ 'location' => 'json', 'type' => 'string' ]
//                                ]
                            ],
                        ],
                        'lastTimestamp' => [ '$ref' => 'LastTimestampAttribute' ],
                    ]
                ],

                'AppFeedbackItems' => [
                    'type' => 'object',
                    'properties' => [
                        'count' => [ '$ref' => 'CountAttribute' ],
                        'hasMore' => [ '$ref' => 'HasMoreAttribute' ],
                        'items' => [
                            'location' => 'json',
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
//                                'properties' => [
//                                    'id' => [ '$ref' => 'IdAttribute' ],
//                                    'date' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'timestamp' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'deviceName' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'data' => [
//                                        'location' => 'json',
//                                        'type' => 'object',
//                                        'properties' => [
//                                            'rating' => [ 'location' => 'json', 'type' => 'integer' ],
//                                            'nps' => [ 'location' => 'json', 'type' => 'integer' ],
//                                            'comment' => [ 'location' => 'json', 'type' => 'string' ],
//                                        ]
//                                    ],
//                                    'custom' => [ 'location' => 'json', 'type' => 'array' ],
//                                    'appId' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'appName' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'appVersion' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'osName' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'osVersion' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'location' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'geoLocation' => [
//                                        'location' => 'json',
//                                        'type' => 'object',
//                                        'attributes' => [
//                                            'country' => [ 'location' => 'json', 'type' => 'string' ],
//                                            'region' => [ 'location' => 'json', 'type' => 'string' ],
//                                            'city' => [ 'location' => 'json', 'type' => 'string' ],
//                                            'lat' => [ 'location' => 'json', 'type' => 'float' ],
//                                            'lon' => [ 'location' => 'json', 'type' => 'float' ],
//                                        ],
//                                    ],
//                                    'freeMemory' => [ 'location' => 'json', 'type' => 'integer' ],
//                                    'totalMemory' => [ 'location' => 'json', 'type' => 'integer' ],
//                                    'freeStorage' => [ 'location' => 'json', 'type' => 'integer' ],
//                                    'totalStorage' => [ 'location' => 'json', 'type' => 'integer' ],
//                                    'screenshot' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'screensize' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'connection' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'ipAddress' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'language' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'orientation' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'batteryLevel' => [ 'location' => 'json', 'type' => 'numeric' ],
//                                ],
                            ],
                        ],
                        'lastTimestamp' => [ '$ref' => 'LastTimestampAttribute' ],
                    ],
                ],

                'WebsiteFeedbackItems' => [
                    'type' => 'object',
                    'properties' => [
                        'count' => [ '$ref' => 'CountAttribute' ],
                        'hasMore' => [ '$ref' => 'HasMoreAttribute' ],
                        'items' => [
                            'location' => 'json',
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
//                                'properties' => [
//                                    'id' => [ '$ref' => 'IdAttribute' ],
//                                    'userAgent' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'comment' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'location' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'date' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'custom' => [ 'location' => 'json', 'type' => 'array' ],
//                                    'email' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'html_snippet' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'image' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'labels' => [ 'location' => 'json', 'type' => 'array' ],
//                                    'nps' => [ 'location' => 'json', 'type' => 'integer' ],
//                                    'publicUrl' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'rating' => [ 'location' => 'json', 'type' => 'integer' ],
//                                    'buttonId' => [ '$ref' => 'ButtonIdAttribute' ],
//                                    'tags' => [ 'location' => 'json', 'type' => 'array' ],
//                                    'url' => [ 'location' => 'json', 'type' => 'string' ],
//                                ]
                            ],
                        ],
                        'lastTimestamp' => [ '$ref' => 'LastTimestampAttribute' ],
                    ],
                ],

                'EmailFeedbackItems' => [
                    'type' => 'object',
                    'properties' => [
                        'count' => [ '$ref' => 'CountAttribute' ],
                        'hasMore' => [ '$ref' => 'HasMoreAttribute' ],
                        'items' => [
                            'location' => 'json',
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
//                                'properties' => [
//                                    'id' => [ '$ref' => 'IdAttribute' ],
//                                    'userAgent' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'comment' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'location' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'date' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'custom' => [ 'location' => 'json', 'type' => 'array' ],
//                                    'email' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'labels' => [ 'location' => 'json', 'type' => 'array' ],
//                                    'nps' => [ 'location' => 'json', 'type' => 'integer' ],
//                                    'publicUrl' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'rating' => [ 'location' => 'json', 'type' => 'integer' ],
//                                    'buttonId' => [ '$ref' => 'ButtonIdAttribute' ],
//                                    'tags' => [ 'location' => 'json', 'type' => 'array' ],
//                                    'url' => [ 'location' => 'json', 'type' => 'string' ],
//                                ]
                            ],
                        ],
                        'lastTimestamp' => [ '$ref' => 'LastTimestampAttribute' ],
                    ],
                ],

                'WebsiteButtonItems' => [
                    'type' => 'object',
                    'properties' => [
                        'count' => [ '$ref' => 'CountAttribute' ],
                        'hasMore' => [ '$ref' => 'HasMoreAttribute' ],
                        'items' => [
                            'location' => 'json',
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
//                                'properties' => [
//                                    'id' => [ '$ref' => 'IdAttribute' ],
//                                    'name' => [ '$ref' => 'NameAttribute' ]
//                                ]
                            ],
                        ],
                        'lastTimestamp' => [ '$ref' => 'LastTimestampAttribute' ],
                    ],
                    'errorResponses' => [
                        [
                            'code' => '403',
                            'phrase' => 'authorisation failed',
                            'class' => 'ClientErrorResponseException'
                        ]
                    ],
                ],

                'EmailButtonItems' => [
                    'type' => 'object',
                    'properties' => [
                        'count' => [ '$ref' => 'CountAttribute' ],
                        'hasMore' => [ '$ref' => 'HasMoreAttribute' ],
                        'items' => [
                            'location' => 'json',
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
//                                'properties' => [
//                                    'id' => [ '$ref' => 'IdAttribute' ],
//                                    'name' => [ '$ref' => 'NameAttribute' ],
//                                    'date' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'introText' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'locale' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'groups' => [ 'location' => 'json', 'type' => 'array' ],
//                                ]
                            ],
                        ],
                        'lastTimestamp' => [ '$ref' => 'LastTimestampAttribute' ],
                    ],
                    'errorResponses' => [
                        [
                            'code' => '403',
                            'phrase' => 'authorisation failed',
                            'class' => 'ClientErrorResponseException'
                        ]
                    ],
                ],

                'InpageWidgetItems' => [
                    'type' => 'object',
                    'properties' => [
                        'count' => [ '$ref' => 'CountAttribute' ],
                        'hasMore' => [ '$ref' => 'HasMoreAttribute' ],
                        'items' => [
                            'location' => 'json',
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
//                                'properties' => [
//                                    'id' => [ '$ref' => 'IdAttribute' ],
//                                    'date' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'name' => [ '$ref' => 'NameAttribute' ],
//                                ]
                            ],
                        ],
                        'lastTimestamp' => [ '$ref' => 'LastTimestampAttribute' ],
                    ],
                    'errorResponses' => [
                        [
                            'code' => '403',
                            'phrase' => 'authorisation failed',
                            'class' => 'ClientErrorResponseException'
                        ]
                    ],
                ],

                'InpageWidgetFeedbackItems' => [
                    'type' => 'object',
                    'properties' => [
                        'count' => [ '$ref' => 'CountAttribute' ],
                        'hasMore' => [ '$ref' => 'HasMoreAttribute' ],
                        'items' => [
                            'location' => 'json',
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
//                                'properties' => [
//                                    'id' => [ '$ref' => 'IdAttribute' ],
//                                    'widgetId' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'date' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'userAgent' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'customData' => [ 'location' => 'json', 'type' => 'array' ],
//                                    'data' => [ 'location' => 'json', 'type' => 'array' ],
//                                    'geo' => [ 'location' => 'json', 'type' => 'array' ],
//                                    'url' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'rating' => [ 'location' => 'json', 'type' => 'numeric' ],
//                                    'comment' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'mood' => [ 'location' => 'json', 'type' => 'numeric' ],
//                                    'nps' => [ 'location' => 'json', 'type' => 'integer' ],
//                                ]
                            ],
                        ],
                        'lastTimestamp' => [ '$ref' => 'LastTimestampAttribute' ],
                    ],
                ],

                'WebsiteCampaignItems' => [
                    'type' => 'object',
                    'properties' => [
                        'count' => [ '$ref' => 'CountAttribute' ],
                        'hasMore' => [ '$ref' => 'HasMoreAttribute' ],
                        'items' => [
                            'location' => 'json',
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
//                                'properties' => [
//                                    'id' => [ '$ref' => 'IdAttribute' ],
//                                    'buttonId' => [ '$ref' => 'ButtonIdAttribute' ],
//                                    'analyticsId' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'date' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'status' => [ 'location' => 'json', 'type' => 'string' ],
//                                    'name' => [ '$ref' => 'NameAttribute' ],
//                                ]
                            ],
                        ],
                        'lastTimestamp' => [ '$ref' => 'LastTimestampAttribute' ],
                    ],
                    'errorResponses' => [
                        [
                            'code' => '403',
                            'phrase' => 'authorisation failed',
                            'class' => 'ClientErrorResponseException'
                        ]
                    ],
                ],

                'WebsiteCampaignStatsItems' => [
                    'type' => 'object',
                    'properties' => [
                        'count' => [ '$ref' => 'CountAttribute' ],
                        'hasMore' => [ '$ref' => 'HasMoreAttribute' ],
                        'items' => [
                            'location' => 'json',
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
//                                'properties' => [
//                                    'id' => [ '$ref' => 'IdAttribute' ],
//                                    'completed' => [ 'location' => 'json', 'type' => 'integer' ],
//                                    'views' => [ 'location' => 'json', 'type' => 'integer' ],
//                                    'conversion' => [ 'location' => 'json', 'type' => 'integer' ],
//                                ]
                            ],
                        ],
                        'lastTimestamp' => [ '$ref' => 'LastTimestampAttribute' ],
                    ],
                    'errorResponses' => [
                        [
                            'code' => '403',
                            'phrase' => 'authorisation failed',
                            'class' => 'ClientErrorResponseException'
                        ]
                    ],
                ],

                'WebsiteCampaignResultItems' => [
                    'type' => 'object',
                    'properties' => [
                        'items' => [
                            'items' => [
                                'location' => 'json',
                                'type' => 'array',
                                'attributes' => [
                                    'type' => 'object',
//                                    'properties' => [
//                                        'id' => [ '$ref' => 'IdAttribute' ],
//                                        'campaignId' => [ 'location' => 'json', 'type' => 'string' ],
//                                        'date' => [ 'location' => 'json', 'type' => 'string' ],
//                                        'userAgent' => [ 'location' => 'json', 'type' => 'string' ],
//                                        'custom' => [ 'location' => 'json', 'type' => 'array' ],
//                                        'data' => [ 'location' => 'json', 'type' => 'array' ],
//                                        'time' => [ 'location' => 'json', 'type' => 'string' ],
//                                        'location' => [ 'location' => 'json', 'type' => 'string' ],
//                                    ],
                                ]
                            ]
                        ],
                    ],
                    'errorResponses' => [
                        [
                            'code' => '403',
                            'phrase' => 'authorisation failed',
                            'class' => 'ClientErrorResponseException'
                        ]
                    ],
                ],

                // Attribute models.
                'ButtonIdAttribute'      => [ 'location' => 'json', 'type' => 'string' ],
                'CountAttribute'         => [ 'location' => 'json', 'type' => 'int' ],
                'HasMoreAttribute'       => [ 'location' => 'json', 'type' => 'boolean' ],
                'IdAttribute'            => [ 'location' => 'json', 'type' => 'string' ],
                'NameAttribute'          => [ 'location' => 'json', 'type' => 'string' ],
                'LastTimestampAttribute' => [ 'location' => 'json', 'type' => 'int' ],

                // Parameter models.
                'LimitParam' => [ 'type' => 'integer', 'location' => 'query' ],
                'MandatoryIdParam' => [ 'type' => 'string', 'location' => 'uri' ],
                'NonMandatoryIdParam' => [ 'type' => 'string', 'location' => 'uri', 'default' => '*' ],
                'SinceParam' => [ 'type' => 'integer', 'location' => 'query' ],

            ]

        ]);
    }

    /**
     * @return Operation[]
     */
    public function getOperations()
    {
        return parent::getOperations();
    }
}