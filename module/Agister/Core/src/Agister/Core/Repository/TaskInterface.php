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
     * Remove task
     *
     * @param Entity\Task $task
     */
    public function delete(Entity\Task $task);

    /**
     * Find all tasks that end after dateFrom
     *
     * @param  DateTime      $dateFrom
     * @param  DateTime      $dateTo
     * @return Entity\Task[]
     */
    public function findAllBetweenDates(DateTime $dateFrom, DateTime $dateTo);

    /**
     * Find when new task should start
     *
     * @return DateTime
     */
    public function findGapForNewTask();

}
