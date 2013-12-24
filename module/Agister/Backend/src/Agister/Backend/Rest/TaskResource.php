<?php

namespace Agister\Backend\Rest;

use Agister\Core\Entity\Task;
use Agister\Core\Repository;
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

    public function __construct(
        Repository\Task $repository,
        InputFilter\Task $inputFilter,
        DoctrineObject $hydrator
    )
    {
        $this->repository = $repository;
        $this->inputFilter = $inputFilter;
        $this->hydrator = $hydrator;
    }

    public function create($data)
    {
        $filter = $this->inputFilter;
        $filter->setData((array) $data);
        if (!$filter->isValid()) {
            print_r($filter->getMessages());
            throw new \Exception("Invalid data!");
        }
        $entity = new Task();
        $this->hydrator->hydrate($filter->getValues(), $entity);
        $this->repository->save($entity);

        return $this->fetch($entity->getId());
    }

    public function fetch($id)
    {
        return $this->hydrator->extract($this->repository->findById($id));
    }

    public function fetchAll($data = array())
    {
        // TODO: do something with this, use hydrator or whatever
        $collection = $this->repository->findAll();
        $ret = array();
        foreach ($collection as $entity) {
            $ret[] = $entity->jsonSerialize();
        }

        return $ret;
    }
}
