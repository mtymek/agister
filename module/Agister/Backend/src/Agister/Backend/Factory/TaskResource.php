<?php

namespace Agister\Backend\Factory;

use Agister\Backend\InputFilter;
use Agister\Backend\Rest\TaskResource as RestTaskResource;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TaskResource implements FactoryInterface
{

    /**
     * Create service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $service = new RestTaskResource(
            $serviceLocator->get('Agister\Core\Service\Task'),
            $entityManager->getRepository('Agister\Core\Entity\Task'),
            new InputFilter\Task(),
            new DoctrineObject($entityManager)
        );

        return $service;
    }
}
