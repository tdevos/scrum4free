<?php
namespace Scrum\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Scrum\Form\Story AS StoryForm;
use Zend\View\Model\ViewModel AS ViewModel;

class StoryController extends AbstractActionController
{
    public function addAction(){
        
        $idProject = $this->getEvent()->getRouteMatch()->getParam("key");
        
        $storyForm = new StoryForm();
        
        if($this->request->isPost()){
            $postData = $this->request->getPost();
            $storyForm->setData($postData);
            if($storyForm->isValid()){
                $postData->set("fk_id_project", $idProject);
                $sm = $this->getServiceLocator()->get("scrum_service_story");
                $sm->saveFromPost($postData);

                $this->redirect()->toRoute("scrum" , array("controller" => "project", "action" => "detail", "key" => $idProject));
            }
        }
        
        return new ViewModel(array("storyForm" => $storyForm));
    }
    
    public function listAction(){
        
        $sm = $this->getServiceLocator()->get("scrum_service_story");
        $listStories = $sm->listStories();
        
        return new ViewModel(array("listStories" => $listStories));
        
    }
    
    public function detailAction(){
        $idStory = $this->getEvent()->getRouteMatch()->getParam("key");
        
        $sm = $this->getServiceLocator()->get("scrum_service_story");
        $storyDetails = $sm->getStoryDetails($idStory);
        
        $sm = $this->getServiceLocator()->get("scrum_service_task");
        $listTasks = $sm->listTasksWithStoryId($idStory);
        
        return new ViewModel(array("storyDetails" => $storyDetails, "listTasks" => $listTasks));
        
    }
}

?>
