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

    public function allocate(Entity\Task $task)
    {
        $task->setStartsAt($this->repository->findGapForNewTask($task->getHoursMax()));
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
            $tmp = clone $task->getStartsAt();
            $tmp->add(new DateInterval('PT' . $task->getHoursMax() . 'H'));
            if ($dateTo < $tmp) {
                $dateTo = $tmp;
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

}
