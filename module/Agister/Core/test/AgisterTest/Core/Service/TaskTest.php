<?php

namespace AgisterTest\AgisterTest\Core\Service;

use Agister\Core\Entity;
use Agister\Core\Service\Task;
use PHPUnit_Framework_TestCase;
use DateTime;

class TaskTest extends PHPUnit_Framework_TestCase
{
    public function testCreateTimelineSetsDatesAccordingToTask()
    {
        $task = new Entity\Task();
        $task->setStartsAt(new DateTime('2013-12-11 12:00')); // Wed
        $task->setHoursMax(48); // 2 full days

        $repository = $this->getMock('Agister\Core\Repository\TaskInterface');
        $service = new Task($repository);

        $timeline = $service->createTimeline(array($task));

        $this->assertInstanceOf('Agister\Core\Entity\Timeline', $timeline);
        $this->assertEquals('2013-12-09 00:00:00', $timeline->getDateFrom()->format("Y-m-d H:i:s"));

        // one week + one hour to fit everything nicely on screen
        $this->assertEquals('2013-12-16 01:00:00', $timeline->getDateTo()->format("Y-m-d H:i:s"));
    }
}