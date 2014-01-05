<?php

namespace Agister\Backend\Rest;

use Agister\Core\Repository;
use Agister\Core\Service;
use Agister\Backend\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use ZF\ApiProblem\ApiProblem;
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
            return new ApiProblem(409, 'Invalid data', null, null, array(
                'messages' => $filter->getMessages(),
            ));
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
            return new ApiProblem(409, 'Invalid data', null, null, array(
                'messages' => $filter->getMessages(),
            ));
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

    public function fetchAll($data = array())
    {
        $collection = $this->repository->findAll();
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
