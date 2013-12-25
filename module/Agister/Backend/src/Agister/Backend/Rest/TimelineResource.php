<?php

namespace Agister\Backend\Rest;

use Agister\Core\Service;
use Agister\Core\Repository;
use Agister\Backend\InputFilter;
use Agister\Backend\Hydrator;
use ZF\Rest\AbstractResourceListener;

class TimelineResource extends AbstractResourceListener
{
    /**
     * @var Service\Task
     */
    private $taskService;

    /**
     * @var Repository\Task
     */
    private $repository;

    /**
     * @var \DoctrineModule\Stdlib\Hydrator\DoctrineObject
     */
    private $hydrator;

    public function __construct(
        Service\Task $taskService,
        Repository\Task $repository,
        Hydrator\Timeline $hydrator
    )
    {
        $this->taskService = $taskService;
        $this->repository = $repository;
        $this->hydrator = $hydrator;
    }

    public function fetch($id)
    {
        $tasks = $this->repository->findAll();
        $timeline = $this->taskService->createTimeline($tasks);
        return $this->hydrator->extract($timeline);
    }

}
