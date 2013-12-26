<?php

namespace Agister\Core\Repository;

use Agister\Core\Entity;
use DateTime;

interface TaskInterface
{

    /**
     * @param  Entity\Task $task
     * @return void
     */
    public function save(Entity\Task $task);

    /**
     * @param  $id
     * @return Entity\Task
     */
    public function findById($id);

    /**
     * @return Entity\Task[]
     */
    public function findAll();

    /**
     * Find when new task should start
     *
     * @param  int $hoursToAllocate
     * @return DateTime
     */
    public function findGapForNewTask($hoursToAllocate);

}
