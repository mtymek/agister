<?php

namespace Agister\Frontend\Factory;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Agister\Frontend\View\Helper\AddTaskForm;

class AddTaskFormViewHelperFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return AddTaskForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new AddTaskForm($serviceLocator->getServiceLocator()->get('Agister\Frontend\Form\AddTask'));
        return $service;
    }
}