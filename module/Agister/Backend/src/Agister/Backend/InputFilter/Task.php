<?php

namespace Agister\Backend\InputFilter;

use Zend\InputFilter\InputFilter;

class Task extends InputFilter
{
    public function __construct()
    {
        $this->add(
            array(
                'name' => 'title',
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'string_length',
                        'max' => 128
                    )
                ),
            )
        );
        $this->add(
            array(
                'name' => 'details',
                'required' => false,
                'value' => ''
            )
        );
        $this->add(
            array(
                'name' => 'hoursMin',
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'int'
                    )
                )
            )
        );
        $this->add(
            array(
                'name' => 'hoursMax',
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'int'
                    )
                )
            )
        );
        $this->add(
            array(
                'name' => 'completed',
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'boolean'
                    )
                )
            )
        );
    }

}
