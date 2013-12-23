<?php

namespace Application\Controller;

use Agister\Core\Entity\Task;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        /** @var \Agister\Core\Service\Task $taskService */
        $taskService = $this->getServiceLocator()->get('Agister\Core\Service\Task');
        $task = new Task();
        $task->setDescription("Test");
        $task->setTitle("Some task!");
        $task->setFinishesFrom(new \DateTime())
            ->setStartsAt(new \DateTime())
            ->setFinishesTo(new \DateTime());
        $taskService->save($task);
        return new ViewModel();
    }
}
