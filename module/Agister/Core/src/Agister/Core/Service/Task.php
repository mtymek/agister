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
     * Save task
     *
     * @param Entity\Task $task
     */
    public function save(Entity\Task $task)
    {
        $this->repository->save($task);
    }

    public function fetchActiveTasks()
    {
        $this->repository->findAllActive();
    }

    /**
     * @param  Entity\Task[] $tasks
     * @return Entity\Timeline
     */
    public function createTimeline($tasks)
    {
        $dateFrom = new DateTime('2050-12-12');
        $dateTo = new DateTime('1970-01-01');

        foreach ($tasks as $task) {
            if ($dateFrom > $task->getStartsAt()) {
                $dateFrom = clone $task->getStartsAt();
            }
            $tmp = clone $task->getStartsAt();
            $tmp->add(new DateInterval('PT' . $task->getHoursMax() . 'H'));
            if ($dateTo < $tmp) {
                $dateTo = $tmp;
            }
        }

        // normalize dateFrom - reset time and ensure it is Monday
        $dateFrom->setTime(0, 0, 0);
        $dateFrom->setISODate($dateFrom->format('Y'), $dateFrom->format('W'), 1);

        // normalize dateTo - reset time and ensure it starts with Monday
        $dateTo->setTime(1, 0, 0);
        // it should wrap for last week of the year
        $dateTo->setISODate($dateTo->format('Y'), $dateTo->format('W')+1, 1);

        $timeline = new Entity\Timeline();
        $timeline->setTasks($tasks);
        $timeline->setDateFrom($dateFrom);
        $timeline->setDateTo($dateTo);
        return $timeline;
    }

}
