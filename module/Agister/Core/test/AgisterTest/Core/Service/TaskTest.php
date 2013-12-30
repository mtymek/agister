<?php

namespace AgisterTest\AgisterTest\Core\Service;

use Agister\Core\Entity;
use Agister\Core\Service\Task;
use PHPUnit_Framework_TestCase;
use DateTime;

class TaskTest extends PHPUnit_Framework_TestCase
{
    public function provideDataForCreateTimeline()
    {
        $dataset = array();

        // single task
        $task = new Entity\Task();
        $task->setStartsAt(new DateTime('2013-12-11 12:00')); // Wed
        $task->setHoursMax(48); // 2 full days
        $dataset[] = array(
            array($task),
            '2013-12-09 00:00:00',
            '2013-12-16 01:00:00'
        );

        // last week of the year
        $task = new Entity\Task();
        $task->setStartsAt(new DateTime('2013-12-30 12:00')); // Wed
        $task->setHoursMax(24); // 2 full days
        $dataset[] = array(
            array($task),
            '2013-12-30 00:00:00',
            '2014-01-06 01:00:00'
        );

        return $dataset;
    }

    /**
     * @param $tasks
     * @param $dateFrom
     * @param $dateTo
     * @dataProvider provideDataForCreateTimeline
     */
    public function testCreateTimelineSetsDatesAccordingToTask($tasks, $dateFrom, $dateTo)
    {

        $repository = $this->getMock('Agister\Core\Repository\TaskInterface');
        $service = new Task($repository);

        $timeline = $service->createTimeline($tasks);

        $this->assertInstanceOf('Agister\Core\Entity\Timeline', $timeline);
        $this->assertEquals($dateFrom, $timeline->getDateFrom()->format("Y-m-d H:i:s"));

        // one week + one hour to fit everything nicely on screen
        $this->assertEquals($dateTo, $timeline->getDateTo()->format("Y-m-d H:i:s"));
    }

}
