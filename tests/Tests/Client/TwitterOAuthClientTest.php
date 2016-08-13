<?php
namespace Twitogram\Tests\Client;

use Abraham\TwitterOAuth\TwitterOAuth;
use Symfony\Component\Yaml\Yaml;
use Twitogram\Client\TwitterOAuthClient;
use Twitogram\Provider\TwitterServiceProvider;
use Twitogram\Service\TwitterService;
use Twitogram\Tests\BaseTestCase;

/**
 * Class TwitterOAuthClientTest
 * @package Twitogram\Tests\Client
 * @coversDefaultClass Twitogram\Client\TwitterOAuthClient
 */
class TwitterOAuthClientTest extends BaseTestCase
{

    protected function getConfig()
    {
        return Yaml::parse(file_get_contents(TwitterServiceProvider::CONFIG_FILE));
    }

    /**
     * @covers ::__construct
     * @covers ::getConnection
     * @covers ::getConfig
     */
    public function testGetConnection()
    {
        $client = new TwitterOAuthClient($this->getConfig());
        $connection = $this->callProtected($client, 'getConnection');

        $this->assertInstanceOf(TwitterOAuth::class, $connection);
    }

    /**
     * @covers ::getUserTimeline
     */
    public function testGetUserTimeline()
    {
        $client = $this->getMockBuilder('Twitogram\Client\TwitterOAuthClient')
            ->disableOriginalConstructor()
            ->setMethods(['getConnection'])
            ->getMock();


        $result = $this->getMockResult('p1.json');

        $mockConnection = $this->getMockBuilder('Abraham\TwitterOAuth\TwitterOAuth')
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        $mockConnection->expects($this->once())->method('get')->with('statuses/user_timeline')->will($this->returnValue($result));

        $client->expects($this->once())->method('getConnection')->will($this->returnValue($mockConnection));

        $params = [
            'screen_name' => 'Ferrari',
            'count' => 8,
            'exclude_replies' => false,
            'include_rts' => true,
        ];

        // $client = new TwitterOAuthClient($this->getConfig());
        
        $result = $client->getUserTimeline($params);

        $this->assertCount(8, $result);
    }
}