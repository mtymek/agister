<?php

namespace Agister\Backend\Rest;

use Agister\Core\Entity\Task;
use Agister\Core\Repository;
use Agister\Core\Service;
use Agister\Backend\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use ZF\Rest\AbstractResourceListener;

class TaskResource extends AbstractResourceListener
{
    /**
     * @var Repository\Task
     */
    private $repository;

    /**
     * @var \Agister\Backend\InputFilter\Task
     */
    private $inputFilter;

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
        InputFilter\Task $inputFilter,
        DoctrineObject $hydrator
    )
    {
        $this->repository = $repository;
        $this->inputFilter = $inputFilter;
        $this->hydrator = $hydrator;
        $this->taskService = $taskService;
    }

    public function create($data)
    {
        $filter = $this->inputFilter;
        $filter->setData((array) $data);
        if (!$filter->isValid()) {
            print_r($filter->getMessages());
            throw new \Exception("Invalid data!");
        }
        $entity = $this->taskService->create();
        $this->hydrator->hydrate($filter->getValues(), $entity);
        $this->taskService->allocate($entity);
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
