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
            )
        );
        $this->add(
            array(
                'name' => 'active',
                'filters' => array(
                    array(
                        'name' => 'boolean'
                    )
                )
            )
        );

        /*$this->add(
            array(
                'name' => 'startsAt',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'datetime'
                    )
                ),
            )
        );*/
    }

}