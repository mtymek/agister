<?php
/**
 * Created by PhpStorm.
 * User: mat
 * Date: 12/23/13
 * Time: 10:44 PM
 */

namespace Agister\Backend\Factory;


use Agister\Backend\Rest\TaskResource as RestTaskResource;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TaskResource implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $service = new RestTaskResource($entityManager->getRepository('Agister\Core\Entity\Task'));
        return $service;
    }
}