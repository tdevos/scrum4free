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

use Scrum\Model\TaskTable AS TaskTable;

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
                "scrum_task_mapper" => "Scrum\Mapper\Task"
            ),
            "factories" => array(
                "Scrum\Model\TaskTable" => function($sm){
                    $dbAdapter = $sm->get("Zend\Db\Adapter\Adapter");
                    $table = new TaskTable($dbAdapter);
                    return $table;
                }
            )
        );
    }
}
