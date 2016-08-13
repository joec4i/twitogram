<?php
namespace Twitogram\Tests\Provider;


use Silex\Application;
use Twitogram\Provider\TwitterServiceProvider;
use Twitogram\Service\TwitterService;
use Twitogram\Tests\BaseTestCase;

/**
 * Class TwitterServiceProviderTest
 * @package Twitogram\Tests\Provider
 * @coversDefaultClass Twitogram\Service\TwitterService
 */
class TwitterServiceProviderTest extends BaseTestCase
{
    protected function getApplication()
    {
        $app = new Application();
        $app->register(new TwitterServiceProvider());
        return $app;
    }

    /**
     * @covers ::register
     */
    public function testRegister()
    {
        $app = $this->getApplication();
        $this->assertInstanceOf(TwitterService::class, $app['twitter.service']);
    }

    /**
     * @covers ::getConfig
     */
    public function testGetConfig()
    {
        $provider = new TwitterServiceProvider();
        $config = $this->callProtected($provider, 'getConfig');
        $this->assertArrayHasKey('consumer_key', $config);
        $this->assertArrayHasKey('consumer_secret', $config);
        $this->assertArrayHasKey('access_token', $config);
        $this->assertArrayHasKey('access_token_secret', $config);
    }
}