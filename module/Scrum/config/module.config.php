<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'scrum' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/scrum[/:controller[/:action]][/:key]',
                    'defaults' => array(
                        'module' => 'Application',
                        'controller' => 'index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard'
                    )
                )
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'index' => 'Scrum\Controller\IndexController',
            'project' => 'Scrum\Controller\ProjectController',
            'story' => 'Scrum\Controller\StoryController',
            'sprint' => 'Scrum\Controller\SprintController',
            'task' => 'Scrum\Controller\TaskController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
//            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
//            'error/404'               => __DIR__ . '/../view/error/404.phtml',
//            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    )
);
