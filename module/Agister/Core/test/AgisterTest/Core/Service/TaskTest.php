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
        $task->setFinishesAtMax(new DateTime('2013-12-14 01:00:00'));
        $dataset[] = array(
            array($task),
            '2013-12-09 00:00:00',
            '2013-12-16 01:00:00'
        );

        // last week of the year
        $task = new Entity\Task();
        $task->setStartsAt(new DateTime('2013-12-30 12:00')); // Wed
        $task->setFinishesAtMax(new DateTime('2014-01-03 01:00:00'));
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
        $dateTime = new DateTime($dateFrom);

        $repository = $this->getMock('Agister\Core\Repository\TaskInterface', array('save', 'findById', 'findAll', 'delete', 'findGapForNewTask',  'findAllFromDate'));
        $repository->expects($this->once())->method('findAllFromDate')
            ->with($dateTime)->will($this->returnValue($tasks));

        $service = new Task($repository);

        $timeline = $service->createTimeline($dateTime);

        $this->assertInstanceOf('Agister\Core\Entity\Timeline', $timeline);
        $this->assertEquals($dateFrom, $timeline->getDateFrom()->format("Y-m-d H:i:s"));

        // one week + one hour to fit everything nicely on screen
        $this->assertEquals($dateTo, $timeline->getDateTo()->format("Y-m-d H:i:s"));
    }

    public function provideDataForGetWorkingHours()
    {
        return array(
            array('2013-12-23 00:00:00', 8), // Mon
            array('2013-12-24 00:00:00', 8), // Tue
            array('2013-12-25 00:00:00', 8), // Wed
            array('2013-12-26 00:00:00', 8), // Thu
            array('2013-12-27 00:00:00', 8), // Fri
            array('2013-12-28 00:00:00', 0), // Sat
            array('2013-12-29 00:00:00', 0), // Sun
            array('2013-12-30 00:00:00', 8), // Mon
        );
    }

    /**
     * @param $date
     * @param $hours
     *
     * @dataProvider provideDataForGetWorkingHours
     */
    public function testGetWorkingHours($date, $hours)
    {
        $repository = $this->getMock('Agister\Core\Repository\TaskInterface');
        $service = new Task($repository);

        $ret = $service->getWorkingHours(new DateTime($date));
        $this->assertEquals($hours, $ret);

    }

    public function provideDataForAllocate()
    {
        return array(
            array('8', '2013-12-30 00:00:00', '2013-12-30 00:00:00', '2013-12-30 08:00:00'), // one full day
            array('10', '2013-12-30 00:00:00', '2013-12-30 00:00:00', '2013-12-31 02:00:00'), // span between two days
            array('12', '2013-12-06 00:00:00', '2013-12-06 00:00:00', '2013-12-09 04:00:00'), // span over the weekend
            array('5', '2013-12-31 05:00:00', '2013-12-31 05:00:00', '2014-01-01 02:00:00'), // span over the weekend
        );
    }


    /**
     * @param $hoursToAllocate
     * @param $gapStart
     * @param $shouldStartAt
     * @param $shouldFinishAt
     *
     * @dataProvider provideDataForAllocate
     */
    public function testAllocate($hoursToAllocate, $gapStart, $shouldStartAt, $shouldFinishAt)
    {
        $repository = $this->getMock(
            'Agister\Core\Repository\TaskInterface',
            array('save', 'findById', 'findAll', 'delete', 'findGapForNewTask',  'findAllFromDate')
        );
        $repository->expects($this->once())->method('findGapForNewTask')
            ->will($this->returnValue(new DateTime($gapStart)));

        $entity = new Entity\Task();
        $entity->setHoursMax($hoursToAllocate)->setHoursMin($hoursToAllocate);

        $service = new Task($repository);
        $service->allocate($entity);
        $this->assertEquals($shouldStartAt, $entity->getStartsAt()->format('Y-m-d H:i:s'));
        $this->assertEquals($shouldFinishAt, $entity->getFinishesAtMax()->format('Y-m-d H:i:s'));
    }

}
