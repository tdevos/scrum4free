<?php
namespace Scrum\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Scrum\Form\Project AS ProjectForm;
use Zend\View\Model\ViewModel AS ViewModel;

class ProjectController extends AbstractActionController
{
    public function addAction(){
        
        $projectForm = new ProjectForm();
        
        if($this->request->isPost()){
            $postData = $this->request->getPost();
            $projectForm->setData($postData);
            if($projectForm->isValid()){
                $sm = $this->getServiceLocator()->get("scrum_service_project");
                $result = $sm->saveFromPost($postData);
                
                $this->redirect()->toRoute("scrum" , array("controller" => "project", "action" => "list"));
            }
        }
        
        return new ViewModel(array("form" => $projectForm));
    }
    
    public function listAction(){
        
        $sm = $this->getServiceLocator()->get("scrum_service_project");
        $listProjects = $sm->listProjects();
        
        return new ViewModel(array("listProjects" => $listProjects));
        
    }
    
    public function detailAction(){
        
        $projectId = $this->getEvent()->getRouteMatch()->getParam("key");
        
        $sm = $this->getServiceLocator()->get("scrum_service_project");
        $projectDetails = $sm->getProjectDetails($projectId);
        
        $sm = $this->getServiceLocator()->get("scrum_service_sprint");
        $listSprint = $sm->getListSprintsWithProjectId($projectId);
        
        $sm = $this->getServiceLocator()->get("scrum_service_story");
        $listStories = $sm->getListOrphanStoriesWithProjectId($projectId);
        
        return new ViewModel(array("projectDetails" => $projectDetails, "listSprint" => $listSprint, "listStories" => $listStories));
        
    }
    
    public function editAction(){
        
        $projectId = $this->getEvent()->getRouteMatch()->getParam("key");
        
        $projectForm = new ProjectForm();
        
        $sm = $this->getServiceLocator()->get("scrum_service_project");
        $projectDetails = $sm->getProjectDetails($projectId);
        
        $projectForm->populateValues($projectDetails);
        
        if($this->request->isPost()){
            $postData = $this->request->getPost();
            $projectForm->setData($postData);
            if($projectForm->isValid()){
                $result = $sm->saveFromPost($postData, $projectId);
                
                $this->redirect()->toRoute("scrum" , array("controller" => "project", "action" => "detail", "key" => $projectId));
            }
        }
        
        return new ViewModel(array("form" => $projectForm));
        
    }
}

?>
