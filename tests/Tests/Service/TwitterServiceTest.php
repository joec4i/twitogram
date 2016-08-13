<?php
namespace Twitogram\Tests\Service;

use Twitogram\Service\TwitterService;
use Twitogram\Tests\BaseTestCase;

/**
 * Class TwitterServiceTest
 * @package Twitogram\Tests\Service
 * @coversDefaultClass Twitogram\Service\TwitterService
 */
class TwitterServiceTest extends BaseTestCase
{
    /**
     * @covers ::histogram
     * @covers ::getTweets
     * @covers 
     */
    public function testHistogram()
    {
        $client = $this->getMockBuilder('Twitogram\Client\TwitterClient')
            ->disableOriginalConstructor()
            ->setMethods(['getUserTimeline'])
            ->getMockForAbstractClass();

        $p1 = $p2 = [
            'screen_name' => 'Ferrari',
            'count' => 8,
            'exclude_replies' => false,
            'include_rts' => true,
        ];

        $p2['max_id'] = 763360525325508609;

        $map = [
            [$p1, $this->getMockResult('p1.json')],
            [$p2, $this->getMockResult('p2.json')],
        ];

        $client->expects($this->exactly(2))->method('getUserTimeline')->will($this->returnValueMap($map));

        $service = new TwitterService($client);

        $histogram = $service->histogram('Ferrari', 8);

        $this->assertCount(24, $histogram);

        $this->assertEquals(10, array_sum(array_values($histogram)));
        $this->assertEquals(4, $histogram[18]);
        $this->assertEquals(3, $histogram[8]);
        $this->assertEquals(3, $histogram[13]);
    }
}