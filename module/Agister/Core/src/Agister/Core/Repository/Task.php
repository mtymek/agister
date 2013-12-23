<?php

namespace Agister\Core\Repository;

use Doctrine\ORM\EntityRepository;
use Agister\Core\Entity;

/**
 * Task
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Task extends EntityRepository implements TaskInterface
{

    /**
     * Save Task to database
     *
     * @param Entity\Task $task
     */
    public function save(Entity\Task $task)
    {
        $this->_em->persist($task);
        $this->_em->flush($task);
    }

}
