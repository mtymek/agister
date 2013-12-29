<?php

namespace Agister\Backend\InputFilter;

class NewTask extends Task
{
    protected $requiredFields = array('title', 'hoursMin', 'hoursMax');

    public function __construct()
    {
        parent::__construct();
        foreach ($this->requiredFields as $field) {
            $this->get($field)->setRequired(true);
        }
    }

}
