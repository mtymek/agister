<?php

namespace Agister\Frontend\Form;

use Zend\Form\Form;

class AddTask extends Form
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->add(
            array(
                'name' => 'hours_max',
                'type' => 'text',
                'options' => array(
                    'label' => 'Est. time',
                    'label_attributes' => array(
                        'class' => 'col-sm-3 control-label'
                    ),
                ),
                'attributes' => array(
                    'class' => 'form-control'
                ),
            )
        );

        $this->add(
            array(
                'name' => 'description',
                'type' => 'textarea',
                'options' => array(
                    'label' => 'Details',
                    'label_attributes' => array(
                        'class' => 'col-sm-3 control-label'
                    ),
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'rows' => 5
                ),
            )
        );

        $this->add(
            array(
                'name' => 'add',
                'type' => 'submit',
                'attributes' => array(
                    'value' => 'Add',
                    'class' => 'btn btn-primary'
                ),
            )
        );


    }

}