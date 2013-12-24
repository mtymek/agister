<?php

namespace Agister\Core\Service;

use Agister\Core\Repository;
use Agister\Core\Entity;

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

}
