<?php

namespace Agister\Backend\Rest;

use Agister\Core\Service;
use Agister\Core\Repository;
use Agister\Backend\InputFilter;
use Agister\Backend\Hydrator;
use DateInterval;
use DateTime;
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
        $dateFrom = $this->getEvent()->getQueryParam('dateFrom');

        if ($dateFrom) {
            $dateFrom = new DateTime($dateFrom);
        } else {
            $dateFrom = new DateTime();
        }

        // normalize date from
        $dateFrom->setTime(0, 0, 0);
        $dateFrom->sub(new DateInterval('P' . ($dateFrom->format('w')?$dateFrom->format('w')-1:6) . 'D'));

        $tasks = $this->repository->findAllFromDate($dateFrom);
        $timeline = $this->taskService->createTimeline($tasks);
        return $this->hydrator->extract($timeline);
    }

}
