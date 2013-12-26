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
                'required' => true,
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
                'name' => 'description',
                'required' => false,
                'value' => ''
            )
        );
        $this->add(
            array(
                'name' => 'hoursMin',
                'required' => true,
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
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'int'
                    )
                )
            )
        );
    }

}
