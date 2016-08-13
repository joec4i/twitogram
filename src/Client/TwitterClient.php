<?php

namespace Twitogram\Client;

use Twitogram\Client\Exception\Exception;

abstract class TwitterClient implements TwitterClientInterface
{

    /**
     * Return the next max_id of given tweets, i.e. the smallest one from the current page
     * @param stdClass[] $tweets
     * @return int|null
     */
    public function getNextMaxId($tweets)
    {
        if (empty($tweets)) {
            return null;
        }
        $ids = array_map(function ($tweet) {
            return $tweet->id;
        }, $tweets);

        return min($ids);
    }


    /**
     * Check if given result is an error message, throw an exception if it is
     * @param mixed $result
     * @throws Exception
     */
    protected function validate($result)
    {
        if ($result instanceof \stdClass && !empty($result->errors)) {
            throw new Exception(json_encode($result));
        }
        return true;
    }

}