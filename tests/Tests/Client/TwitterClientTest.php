<?php

namespace Twitogram\Tests\Client;
use Twitogram\Tests\BaseTestCase;

/**
 * Class TwitterClientTest
 * @package Twitogram\Tests\Client
 * @coversDefaultClass Twitogram\Client\TwitterClient
 */
class TwitterClientTest extends BaseTestCase
{
    /**
     * @covers ::getNextMaxId
     */
    public function testGetNextId()
    {
        $client = $this->getMockBuilder('Twitogram\Client\TwitterClient')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $tweets = $this->getMockResult('p1.json');

        $this->assertEquals(763360525325508609, $client->getNextMaxId($tweets));
    }
}