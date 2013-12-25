<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'Agister\Backend\Hydrator\Timeline' => 'Agister\Backend\Factory\TimelineHydrator',
            'Agister\Backend\Rest\TaskResource' => 'Agister\Backend\Factory\TaskResource',
            'Agister\Backend\Rest\TimelineResource' => 'Agister\Backend\Factory\TimelineResource',
        ),
    ),
    'router' => array(
        'routes' => array(
            'api' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/api',
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'tasks' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/tasks[/:id]',
                            'defaults' => array(
                                'controller' => 'Agister\Backend\TaskApiController',
                            ),
                        ),
                    ),
                    'timeline' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/timeline/[:id]',
                            'defaults' => array(
                                'controller' => 'Agister\Backend\TimelineApiController',
                                'id' => 1,
                            ),
                        ),
                    ),
                ),
            ),
        )
    ),
    'zf-rest' => array(
        'Agister\Backend\TaskApiController' => array(
            'identifier'              => 'Tasks',
            'listener'                => 'Agister\Backend\Rest\TaskResource',
            'resource_identifiers'    => array('TaskResource'),
            'collection_http_options' => array('get', 'post', 'delete'),
            'collection_name'         => 'tasks',
            'page_size'               => 10,
            'resource_http_options'   => array('get'),
            'route_name'              => 'api/tasks',
        ),
        'Agister\Backend\TimelineApiController' => array(
            'identifier'              => 'Timeline',
            'listener'                => 'Agister\Backend\Rest\TimelineResource',
            'resource_identifiers'    => array('TimelineResource'),
            'resource_http_options'   => array('get'),
            'route_name'              => 'api/timeline',
        ),
    ),
);
