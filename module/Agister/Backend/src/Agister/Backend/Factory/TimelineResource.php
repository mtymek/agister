<?php

namespace Agister\Backend\Factory;

use Agister\Backend\InputFilter;
use Agister\Backend\Rest\TimelineResource as TimelineTaskResource;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TimelineResource implements FactoryInterface
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
        $service = new TimelineTaskResource(
            $serviceLocator->get('Agister\Core\Service\Task'),
            $entityManager->getRepository('Agister\Core\Entity\Task'),
            $serviceLocator->get('Agister\Backend\Hydrator\Timeline')
        );

        return $service;
    }
}
