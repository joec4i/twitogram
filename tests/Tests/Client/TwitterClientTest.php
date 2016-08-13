<?php

namespace Twitogram\Tests\Client;
use Twitogram\Client\Exception\Exception;
use Twitogram\Client\TwitterClient;
use Twitogram\Tests\BaseTestCase;

/**
 * Class TwitterClientTest
 * @package Twitogram\Tests\Client
 * @coversDefaultClass Twitogram\Client\TwitterClient
 */
class TwitterClientTest extends BaseTestCase
{
    /**
     * @var TwitterClient
     */
    private $client;

    public function setUp()
    {
        $this->client = $this->getMockBuilder('Twitogram\Client\TwitterClient')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
    }

    /**
     * @covers ::getNextMaxId
     */
    public function testGetNextId()
    {

        $tweets = $this->getMockResult('p1.json');
        $this->assertEquals(763360525325508609, $this->client->getNextMaxId($tweets));

        $this->assertNull(null, $this->client->getNextMaxId([]));
    }

    /**
     * @covers ::validate
     * @expectedException Exception
     */
    public function testValidateException()
    {
        $error = json_decode('{"errors": [{"message": "something is wrong", "code": 500}]}');
        $this->callProtected($this->client, 'validate', [$error]);
    }

    /**
     * @covers ::validate
     */
    public function testValidate()
    {
        $this->assertTrue($this->callProtected($this->client, 'validate', [[]]));
    }


}