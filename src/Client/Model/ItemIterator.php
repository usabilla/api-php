<?php
/**
 * Created by PhpStorm.
 * User: viorelgeorge
 * Date: 26/01/15
 * Time: 14:53
 */

namespace Usabilla\API\Client\Model;
use Guzzle\Service\Resource\ResourceIterator;

class ItemIterator extends ResourceIterator {

    protected function sendRequest()
    {
        // If a next token is set, then add it to the command
        if ($this->nextToken) {
            $this->command->set('since', $this->nextToken);
        }

        // Execute the command and parse the result
        $result = $this->command->execute();

        // Parse the next timestamp
        $this->nextToken = (isset($result['lastTimestamp'])  && $result['hasMore']) ? $result['lastTimestamp'] : false;

        return $result;
    }

} 