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

namespace Usabilla\API\Client;

use Usabilla\API\Credentials\Credentials;
use Usabilla\API\Signature\Signature;
use Guzzle\Service\ClientInterface as GuzzleClientInterface;

interface ClientInterface extends GuzzleClientInterface
{
    /**
     * Returns the Usabilla credentials associated with the client
     *
     * @return Credentials
     */
    public function getCredentials();
    /**
     * Sets the credentials object associated with the client
     *
     * @param Credentials $credentials Credentials object to use
     *
     * @return self
     */
    public function setCredentials(Credentials $credentials);
    /**
     * Returns the signature implementation used with the client
     *
     * @return Signature
     */
    public function getSignature();

}