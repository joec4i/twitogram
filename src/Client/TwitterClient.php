<?php

namespace Twitogram\Client;

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
}