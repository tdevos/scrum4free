<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Scrum;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig(){
        return array(
            "invokables"=>array(
                "scrum_service_task" => "Scrum\Service\Task",
                "scrum_service_project" => "Scrum\Service\Project",
                "scrum_service_story" => "Scrum\Service\Story",
                "scrum_service_sprint" => "Scrum\Service\Sprint",
                
                "scrum_task_mapper" => "Scrum\Mapper\Task",
                "scrum_project_mapper" => "Scrum\Mapper\Project",
                "scrum_story_mapper" => "Scrum\Mapper\Story",
                "scrum_sprint_mapper" => "Scrum\Mapper\Sprint"
            ),
            "factories" => array(
                "Scrum\Model\TaskTable" => function($sm){
                    $dbAdapter = $sm->get("Zend\Db\Adapter\Adapter");
                    $table = new Model\TaskTable($dbAdapter);
                    return $table;
                },
                "Scrum\Model\ProjectTable" => function($sm){
                    $dbAdapter = $sm->get("Zend\Db\Adapter\Adapter");
                    $table = new Model\ProjectTable($dbAdapter);
                    return $table;
                },
                "Scrum\Model\StoryTable" => function($sm){
                    $dbAdapter = $sm->get("Zend\Db\Adapter\Adapter");
                    $table = new Model\StoryTable($dbAdapter);
                    return $table;
                },
                "Scrum\Model\SprintTable" => function($sm){
                    $dbAdapter = $sm->get("Zend\Db\Adapter\Adapter");
                    $table = new Model\SprintTable($dbAdapter);
                    return $table;
                }
            )
        );
    }
}
