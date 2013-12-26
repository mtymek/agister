<?php

return array(
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../asset',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
        ),
    ),
    'router' => array(
        'routes' => array(
            'dashboard' => array(
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
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        // Just for now...
        'display_exceptions' => true,
    ),
);
