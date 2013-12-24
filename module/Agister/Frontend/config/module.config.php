<?php

return array(
    'service_manager' => array(
        'factories' => array(
        ),
    ),
    'router' => array(
        'routes' => array(
            'agister-backend' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard',
                    'defaults' => array(
                        'controller' => 'Agister\Frontend\Controller\Dashboard',
                        'action' => 'index'
                    ),
                ),
            ),
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Agister\Frontend\Controller\Dashboard' => 'Agister\Frontend\Controller\DashboardController'
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        // Just for now...
        'display_exceptions' => true,
    ),
);
