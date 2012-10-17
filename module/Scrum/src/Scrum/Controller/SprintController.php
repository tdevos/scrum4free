<?php
namespace Scrum\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Scrum\Form\Sprint AS SprintForm;
use Zend\View\Model\ViewModel;

class SprintController extends AbstractActionController
{
    
    public function addAction(){
        
        $idProject = $this->getEvent()->getRouteMatch()->getParam("key");
        
        $sprintForm = new SprintForm();
        
        if($this->request->isPost()){
            $postData = $this->request->getPost();
            $sprintForm->setData($postData);
            if($sprintForm->isValid()){
                $postData->set("fk_id_project", $idProject);
                $sm = $this->getServiceLocator()->get("scrum_service_sprint");
                $sm->saveFromPost($postData);
                
                $this->redirect()->toRoute("scrum" , array("controller" => "project", "action" => "detail", "key" => $idProject));
            }
        }
        
        return new ViewModel(array("sprintForm" => $sprintForm));
        
    }
    
    public function listAction(){
        
        $sm = $this->getServiceLocator()->get("scrum_service_sprint");
        $listSprints = $sm->listSprints();
        
        return new ViewModel(array("listSprints" => $listSprints));
        
    }
    
    public function detailAction(){
        
        $sprintId = $this->getEvent()->getRouteMatch()->getParam("key");
        
        $sm = $this->getServiceLocator()->get("scrum_service_sprint");
        $sprintDetails = $sm->getSprintDetails($sprintId);
        
        $sm = $this->getServiceLocator()->get("scrum_service_story");
        $listStories = $sm->getListStoriesWithSprintId($sprintId);
        
        $ophanStories = $sm->getListOrphanStoriesWithProjectId($sprintDetails->fk_id_project);
        
        $linkForm = new \Scrum\Form\LinkStorySprint();
        
        $linkForm->setAttribute("action", $this->getRequest()->getBasePath()."/scrum/sprint/link/" .$sprintId );
        
        $options[0] = "";
        
        foreach ($ophanStories AS $orphanStory){
            $options[$orphanStory->id_story] = $orphanStory->name;
        }
        
        $linkForm->get("fk_id_story")->setOptions(array("value_options" => $options));
        
        return new ViewModel(array("sprintDetails" => $sprintDetails, "listStories" => $listStories, "linkForm" => $linkForm));
        
    }
    
    function linkAction(){
        
        $sprintId = $this->getEvent()->getRouteMatch()->getParam("key");
        
        $storyId = $this->getRequest()->getPost("fk_id_story");
        
        $sm = $this->getServiceLocator()->get("scrum_service_story");
        
        if($storyId != 0)
        $sm->linkToSprint($sprintId, $storyId);
        
        $this->redirect()->toRoute("scrum" , array("controller" => "sprint", "action" => "detail", "key" => $sprintId));
        
        
    }
    
    function editAction(){
        
        $idSprint = $this->getEvent()->getRouteMatch()->getParam("key");
        
        $sprintForm = new SprintForm();
        $sm = $this->getServiceLocator()->get("scrum_service_sprint");
        
        $sprintDetails = $sm->getSprintDetails($idSprint);
        
        $sprintForm->populateValues($sprintDetails);
        
        if($this->request->isPost()){
            $postData = $this->request->getPost();
            $sprintForm->setData($postData);
            if($sprintForm->isValid()){
                $postData->set("fk_id_project", $sprintDetails->fk_id_project);
                $sm->saveFromPost($postData, $idSprint);
                
                $this->redirect()->toRoute("scrum" , array("controller" => "sprint", "action" => "detail", "key" => $idSprint));
            }
        }
        
        return new ViewModel(array("sprintForm" => $sprintForm));
        
    }

}

?>
