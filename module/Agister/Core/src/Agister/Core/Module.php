<?php

namespace Agister\Core;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../../../config/module.config.php';
    }
}
