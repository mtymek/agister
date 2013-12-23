<?php

namespace Agister\Backend\Rest;

use Agister\Core\Repository;
use ZF\Rest\AbstractResourceListener;

class TaskResource extends AbstractResourceListener
{
    /**
     * @var Repository\Task
     */
    private $repository;

    public function __construct(Repository\Task $repository)
    {
        $this->repository = $repository;
    }

    public function save(array $data)
    {

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
