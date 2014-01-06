<?php

namespace Agister\Backend\Rest;

use Agister\Core\Repository;
use Agister\Core\Service;
use Agister\Backend\InputFilter;
use DateTime;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use ZF\Rest\AbstractResourceListener;

class TaskResource extends AbstractResourceListener
{
    /**
     * @var Repository\Task
     */
    private $repository;

    /**
     * @var \Agister\Backend\InputFilter\NewTask
     */
    private $newTaskInputFilter;

    /**
     * @var \Agister\Backend\InputFilter\Task
     */
    private $taskInputFilter;

    /**
     * @var \DoctrineModule\Stdlib\Hydrator\DoctrineObject
     */
    private $hydrator;

    /**
     * @var \Agister\Core\Service\Task
     */
    private $taskService;

    public function __construct(
        Service\Task $taskService,
        Repository\Task $repository,
        InputFilter\NewTask $newTaskInputFilter,
        InputFilter\Task $taskInputFilter,
        DoctrineObject $hydrator
    )
    {
        $this->repository = $repository;
        $this->newTaskInputFilter = $newTaskInputFilter;
        $this->taskInputFilter = $taskInputFilter;
        $this->hydrator = $hydrator;
        $this->taskService = $taskService;
    }

    public function create($data)
    {
        $filter = $this->newTaskInputFilter;
        $filter->setData((array) $data);
        if (!$filter->isValid()) {
            throw new \Exception("Invalid data!");
        }
        $entity = $this->taskService->create();
        $this->hydrator->hydrate($filter->getValues(), $entity);
        $this->taskService->allocate($entity);
        $this->repository->save($entity);

        return $this->fetch($entity->getId());
    }

    public function update($id, $data)
    {
        $data = (array) $data;
        $filter = $this->taskInputFilter;
        $filter->setData($data);
        if (!$filter->isValid()) {
            throw new \Exception("Invalid data!");
        }
        $entity = $this->repository->findById($id);

        // ensure we pass only properties that were given as an input
        $values = $filter->getValues();
        $values = array_intersect_key($values, $data);

        $this->hydrator->hydrate($values, $entity);
        $this->repository->save($entity);

        return $this->fetch($entity->getId());
    }

    public function fetch($id)
    {
        return $this->hydrator->extract($this->repository->findById($id));
    }

    public function fetchAll($params = array())
    {
        $dateFrom = isset($params['dateFrom'])?new DateTime($params['dateFrom']):new DateTime('1970-01-01 00:00:00');
        $dateTo = isset($params['dateTo'])?new DateTime($params['dateTo']):new DateTime('2050-01-01 00:00:00');

        $collection = $this->repository->findAllBetweenDates($dateFrom, $dateTo);
        $ret = array();
        foreach ($collection as $entity) {
            $ret[] = $this->hydrator->extract($entity);
        }

        return $ret;
    }

    public function delete($id)
    {
        $task = $this->repository->findById($id);
        $this->repository->delete($task);

        return true;
    }
}
