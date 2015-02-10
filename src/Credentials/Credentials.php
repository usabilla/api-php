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
 * Basic implementation of the Credentials
 */
class Credentials
{
    /** @var string Access Key */
    protected $key;
    /** @var string Secret Key */
    protected $secret;


    /**
     * Constructs a new Credentials object, with the specified
     * access key and secret key
     *
     * @param string $accessKeyId     AWS access key ID
     * @param string $secretAccessKey AWS secret access key
     */
    public function __construct($accessKeyId, $secretAccessKey)
    {
        $this->key = trim($accessKeyId);
        $this->secret = trim($secretAccessKey);
    }
    public function serialize()
    {
        return json_encode(array(
            "key"       => $this->key,
            "secret"    => $this->secret,
        ));
    }

    public function unserialize($serialized)
    {
        $data = json_decode($serialized, true);
        $this->key    = $data["key"];
        $this->secret = $data["secret"];
    }



    public function getAccessKeyId()
    {
        return $this->key;
    }


    public function getSecretKey()
    {
        return $this->secret;
    }


    public function setAccessKeyId($key)
    {
        $this->key = $key;
        return $this;
    }
    public function setSecretKey($secret)
    {
        $this->secret = $secret;
        return $this;
    }
}