<?php

namespace Scrum\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Scrum\Form\Task AS TaskForm;
use Zend\View\Model\ViewModel AS ViewModel;

class TaskController extends AbstractActionController
{
    public function addAction() {
        
        $idStory = $this->getEvent()->getRouteMatch()->getParam("key");
        
        $taskForm = new TaskForm();
        
        if($this->getRequest()->isPost()){
            $postData = $this->getRequest()->getPost();
            $taskForm->setData($postData);
            if($taskForm->isValid()){
                $postData->set("fk_id_story", $idStory);
                $sm = $this->getServiceLocator()->get("scrum_service_task");
                $sm->saveFromPost($postData);
                
                $this->redirect()->toRoute("scrum" , array("controller" => "story", "action" => "detail", "key" => $idStory));
            }
        }
        
        return new ViewModel(array("taskForm" => $taskForm));
        
    }
    
    function listAction(){
        
        $storyId = $this->getEvent()->getRouteMatch()->getParam("key");
        
        $sm = $this->getServiceLocator()->get("scrum_service_task");
        $listTasks = $sm->listTasksWithStoryId($storyId);
        
        return new ViewModel(array("listTasks" => $listTasks));
        
    }
}

?>
