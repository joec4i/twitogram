<?php
namespace Twitogram\Client;

/**
 * TwitterClientInterface
 * @package Twitogram\Service
 */
interface TwitterClientInterface
{
    /**
     * Call statuses/user_timeline and return the response
     * @param array $parameters
     * @return \stdClass[]
     */
    public function getUserTimeline(array $parameters);

    /**
     * Return the next max_id of given tweets, i.e. the smallest one from the current page
     * @param stdClass[] $tweets
     * @return int|null
     */
    public function getNextMaxId($tweets);
}
