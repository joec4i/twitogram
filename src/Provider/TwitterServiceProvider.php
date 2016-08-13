<?php

namespace Twitogram\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Yaml\Yaml;
use Twitogram\Client\TwitterOAuthClient;
use Twitogram\Service\TwitterService;

/**
 * The class that wires the TwitterService related classes together
 * @package Twitogram\Provider
 */
class TwitterServiceProvider implements ServiceProviderInterface
{
    // TODO: environment based configuration
    const CONFIG_FILE = __DIR__ . '/../../config/twitter.yml';

    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $config = $this->getConfig();
        $client = new TwitterOAuthClient($config);

        $app['twitter.service'] = function () use ($client) {
            return new TwitterService($client);
        };
    }

    /**
     * @return array
     */
    protected function getConfig()
    {
        return Yaml::parse(file_get_contents(self::CONFIG_FILE));
    }
}