<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'Agister\Core\Service\Task' => 'Agister\Core\Factory\TaskService',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'agister_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Agister/Core/Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Agister\Core\Entity' => 'agister_annotation_driver'
                )
            )
        )
    )
);
