<?php

namespace Agister\Core\Repository;

use Agister\Core\Entity;

interface TaskInterface
{

    public function save(Entity\Task $task);

    public function findAllActive();

}