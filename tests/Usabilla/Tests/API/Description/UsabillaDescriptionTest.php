<?php

/**
 * Copyright Usabilla.com. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * https://github.com/usabilla/php-client
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Usabilla\Tests\API\Description;

use Usabilla\API\Description\UsabillaDescription;

class UsabillaDescriptionTest extends \PHPUnit_Framework_TestCase
{
    /** @var UsabillaDescription */
    private $description;

    public function setUp()
    {
        $this->description = new UsabillaDescription();
    }

    public function testGetOperations()
    {
        $operations = $this->description->getOperations();
        $this->assertEquals(13, count($operations));
    }
}