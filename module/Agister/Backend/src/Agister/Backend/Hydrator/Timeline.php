<?php

namespace Agister\Backend\Hydrator;

use Agister\Core\Entity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class Timeline
{
    /**
     * @var DoctrineObject
     */
    protected $taskHydrator;

    /**
     * @param DoctrineObject $taskHydrator
     */
    public function __construct(DoctrineObject $taskHydrator)
    {
        $this->taskHydrator = $taskHydrator;
    }

    /**
     * @param  Entity\Timeline $timeline
     * @return array
     */
    public function extract(Entity\Timeline $timeline)
    {
        $tasks = array();

        foreach ($timeline->getTasks() as $task) {
            $tasks[] = $this->taskHydrator->extract($task);
        }

        return array(
            'id' => 1,
            'tasks' => $tasks,
            'dateFrom' => $timeline->getDateFrom()->format('Y-m-d H:i:s'),
            'dateTo' => $timeline->getDateTo()->format('Y-m-d H:i:s'),
            'length' => $timeline->getLength(),
            'scale' => 100/$timeline->getLength(),
        );
    }

}
