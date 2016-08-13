<?php
namespace Twitogram\Service;

use Twitogram\Client\TwitterClientInterface;

/**
 * Class TwitterService
 * @package Twitogram\Service
 */
class TwitterService
{
    /**
     * @var TwitterClientInterface
     */
    protected $client;

    /**
     * TwitterService constructor.
     * @param TwitterClientInterface $client
     */
    public function __construct(TwitterClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Get histogram of tweets from given user's timeline
     * @param string $screenName
     * @param int $perpage
     * @return array
     */
    public function histogram($screenName, $perpage = 200)
    {
        // init the histogram
        $histogram = array_fill(0, 24, 0);

        $maxId = null;

        do {
            $tweets = $this->getTweets($screenName, $maxId, $perpage);

            foreach ($tweets as $tweet) {
                $hour = date_parse($tweet->created_at)['hour'];
                $histogram[$hour] ++;
            }

            $maxId = $this->client->getNextMaxId($tweets);
        } while (count($tweets) >= $perpage);

        return $histogram;
    }


    /**
     * Paginated user timeline query
     * @param string $screenName
     * @param int|null $maxId
     * @param int $perpage
     * @return \stdClass
     */
    protected function getTweets($screenName, $maxId = null, $perpage = 200)
    {
        $params = [
            'screen_name' => $screenName,
            'count' => $perpage,
            'exclude_replies' => false,
            'include_rts' => true,
        ];

        if (!empty($maxId)) {
            $params['max_id'] = $maxId;
        }

        return $this->client->getUserTimeline($params);
    }

}