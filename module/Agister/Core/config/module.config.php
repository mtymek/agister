<?php

return array(
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
