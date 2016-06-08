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

namespace Usabilla\API\Credentials;

/**
 * Basic implementation of the Credentials.
 */
class Credentials
{
    /** @var string Access Key */
    protected $accessKey;

    /** @var string Secret Key */
    protected $secretKey;

    /**
     * Constructs a new Credentials object, with the specified access key and secret key.
     *
     * @param string $accessKey Usabilla access key
     * @param string $secretKey Usabilla secret key
     */
    public function __construct($accessKey, $secretKey)
    {
        $this->setAccessKey($accessKey);
        $this->setSecretKey($secretKey);
    }

    /**
     * @return string
     */
    public function getAccessKey()
    {
        return $this->accessKey;
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param string $accessKey
     *
     * @return $this
     */
    public function setAccessKey($accessKey)
    {
        if (is_string($accessKey)) {
            $this->accessKey = trim($accessKey);
        }

        return $this;
    }

    /**
     * @param string $secretKey
     *
     * @return $this
     */
    public function setSecretKey($secretKey)
    {
        if (is_string($secretKey)) {
            $this->secretKey = trim($secretKey);
        }

        return $this;
    }
}