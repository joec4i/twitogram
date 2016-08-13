<?php
namespace Twitogram\Client;

use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * A thin wrapper of Abraham Williams's TwitterOAuth client
 * @package Twitogram\Service
 */
class TwitterOAuthClient extends TwitterClient implements TwitterClientInterface
{
    /** @var TwitterOAuth */
    private $connection;

    /**
     * @var array
     */
    private $config;

    /**
     * TwitterOAuthClient constructor.
     * @param array $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return TwitterOAuth
     */
    protected function getConnection()
    {
        if (!$this->connection) {
            $this->connection = new TwitterOAuth(
                $this->getConfig('consumer_key'),
                $this->getConfig('consumer_secret'),
                $this->getConfig('access_token'),
                $this->getConfig('access_token_secret')
            );
        }

        return $this->connection;
    }

    /**
     * @param string $key
     * @return string
     * @throws \Exception
     */
    protected function getConfig($key)
    {
        if (!isset($this->config[$key])) {
            throw new \Exception("Config key not found - $key");
        }

        return $this->config[$key];
    }

    /**
     * Call the user_timeline api via TwitterOAuthClient
     * @param array $parameters
     * @return \stdClass[]
     */
    public function getUserTimeline(array $parameters)
    {
        $result = $this->getConnection()->get('statuses/user_timeline', $parameters);

        $this->validate($result);

        return $result;
    }

}