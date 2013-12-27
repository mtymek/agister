<?php

namespace Agister\Frontend\View\Helper;


use Agister\Frontend\Form\AddTask;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class AddTaskForm extends AbstractHelper
{

    /**
     * @var \Agister\Frontend\Form\AddTask
     */
    private $addTaskForm;

    /**
     * Class constructor
     *
     * @param AddTask $addTaskForm
     */
    public function __construct(AddTask $addTaskForm)
    {
        $this->addTaskForm = $addTaskForm;
    }

    public function __invoke()
    {
        $vm = new ViewModel();
        $vm->form = $this->addTaskForm;
        $vm->setTemplate('agister/partial/add-task-form.phtml');
        return $this->getView()->render($vm);
    }

}