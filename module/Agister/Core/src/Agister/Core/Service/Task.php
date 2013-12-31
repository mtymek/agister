<?php

namespace Agister\Core\Service;

use Agister\Core\Repository;
use Agister\Core\Entity;
use DateInterval;
use DateTime;

class Task
{
    /**
     * @var Repository\TaskInterface
     */
    private $repository;

    /**
     * Class constructor
     *
     * @param Repository\TaskInterface $repository
     */
    public function __construct(Repository\TaskInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create new task
     * @return Entity\Task
     */
    public function create()
    {
        $task = new Entity\Task();

        return $task;
    }

    /**
     * Find when given task can be started, and when it can be finished
     *
     * @param Entity\Task $task
     */
    public function allocate(Entity\Task $task)
    {
        $startsAt = $this->repository->findGapForNewTask();

        $remainingHours = $task->getHoursMax();
        $current = clone $startsAt;
        $current->setTime(0, 0, 0);

        // note: we don't ever display exact hours. So we can safely assume that work
        // always starts at 00:00. We use it to calculate hours remaining of first day
        $hoursToDistribute = $this->getWorkingHours($startsAt) - $startsAt->format('H');

        while (true) {
            if ($remainingHours <= $hoursToDistribute) {
                $current->setTime($remainingHours, 0, 0);
                break;
            }

            $current->add(new DateInterval('P1D'));
            $remainingHours -= $hoursToDistribute;
            $hoursToDistribute = $this->getWorkingHours($current);
        }

        $task->setStartsAt($startsAt);
        $task->setFinishesAtMax($current);
        $task->setFinishesAtMin($current);
    }

    /**
     * @param  DateTime        $dateFrom
     * @return Entity\Timeline
     */
    public function createTimeline(DateTime $dateFrom)
    {
        $tasks = $this->repository->findAllFromDate($dateFrom);
        $dateTo = new DateTime('1970-01-01');

        foreach ($tasks as $task) {
            if ($dateTo < $task->getFinishesAtMax()) {
                $dateTo = clone $task->getFinishesAtMax();
            }
        }

        // normalize dateFrom - reset time and ensure it is Monday
        $dateFrom->setTime(0, 0, 0);
        $dateFrom->sub(new DateInterval('P' . ($dateFrom->format('w')?$dateFrom->format('w')-1:6) . 'D'));

        // normalize dateTo - reset time and ensure it starts on next Monday after $dateTo
        $dateTo->setTime(1, 0, 0);
        $dateTo->add(new DateInterval('P7D'));
        $dateTo->sub(new DateInterval('P' . ($dateTo->format('w')?$dateTo->format('w')-1:6) . 'D'));

        $timeline = new Entity\Timeline();
        $timeline->setTasks($tasks);
        $timeline->setDateFrom($dateFrom);
        $timeline->setDateTo($dateTo);

        return $timeline;
    }

    /**
     * Return number of hours that can be allocated on given day
     *
     * @param DateTime $day
     * @return int
     */
    public function getWorkingHours(DateTime $day)
    {
        // don't work on Saturday & Sunday
        if ($day->format('N') == 6
            || $day->format('N') == 7
        ) {
            return 0;
        }
        return 8;
    }

}
