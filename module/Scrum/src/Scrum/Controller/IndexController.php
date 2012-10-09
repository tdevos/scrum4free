<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Scrum\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Scrum\Model\TaskTable AS TaskTable;
use Scrum\Service\Task AS TaskService;
use Scrum\Entity\Task AS TaskEntity;
use Zend\View\Model\JsonModel AS JsonModel;
use Scrum\Form\Task AS Form_Task;

class IndexController extends AbstractActionController
{
    const ajaxResponseOk = "ok";
    const ajaxResponseNotOk = "notok";
    
    public function indexAction()
    {
        $sm = $this->getServiceLocator()->get("scrum_service_task");
        $allTaskByStatus = $sm->getAllByStatus();
        
        $form = new Form_Task();
        
        return new ViewModel(array("allTasksByStatus" => $allTaskByStatus, "taskForm" => $form));
    }
    
    public function ajaxChangeStatusAction(){
        
        $idTask = $this->getRequest()->getPost("id_task");
        $idStatus = $this->getRequest()->getPost("id_status");
        
        $service = $this->getServiceLocator()->get("scrum_service_task");
        $statusChanged = $service->changeStatus($idTask, $idStatus);
        
        $response = ($statusChanged == 1)?self::ajaxResponseOk:  self::ajaxResponseNotOk;
        
        $view = new JsonModel(array("response" => $response));
        
        return $view;
        
    }
    
    public function ajaxAddTaskAction(){
        
        $taskEntity = new TaskEntity;
        
        $taskEntity->setTitle($this->getRequest()->getPost("title"));
        $taskEntity->setTime($this->getRequest()->getPost("time"));
        $taskEntity->setDescription($this->getRequest()->getPost("description"));
        $taskEntity->setActors($this->getRequest()->getPost("actors"));
        
        $taskEntity->setStatus(1);
        
        $service = $this->getServiceLocator()->get("scrum_service_task");
        $taskSaved = $service->save($taskEntity);
        
        $response = ($taskSaved == 1)?self::ajaxResponseOk:  self::ajaxResponseNotOk;
        
        $view = new JsonModel(array("response" => $response));
        
        return $view;
        
    }
    
    public function ajaxRemoveTaskAction(){
        
        $service = $this->getServiceLocator()->get("scrum_service_task");
        $taskRemoved = $service->delete($this->getRequest()->getPost("id_task"));
        
        $response = ($taskRemoved == 1) ? self::ajaxResponseOk : self::ajaxResponseNotOk ;
        
        $view = new JsonModel(array("response" => $response));
        
        return $view;
        
    }
}
