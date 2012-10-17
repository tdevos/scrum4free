<?php

namespace Scrum\Service;

Use Zend\EventManager\EventManager AS EventManager;
use Zend\ServiceManager\ServiceManagerAwareInterface AS ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager AS ServiceManager;
use Scrum\Entity\Project AS ProjectEntity;

class Project extends EventManager implements ServiceManagerAwareInterface {

    protected $serviceManager;
    protected $projectMapper;
    protected $sprintMapper;

    public function setServiceManager(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function getProjectMapper() {
        if (null === $this->projectMapper) {
            $this->projectMapper = $this->getServiceManager()->get("scrum_project_mapper");
        }
        return $this->projectMapper;
    }
    
    public function getSprintMapper() {
        if (null === $this->sprintMapper) {
            $this->sprintMapper = $this->getServiceManager()->get("scrum_sprint_mapper");
        }
        return $this->sprintMapper;
    }

    /***************************************************************************************************************** */
    
    public function saveFromPost(\ArrayObject $formData, $idProject = null){
        
        $projectEntity = new ProjectEntity();
        
        if(!is_null($idProject))
            $projectEntity->setIdProject ($idProject);
        
        $projectEntity->setName($formData->name);
        $projectEntity->setDescription($formData->description);
        
        $this->getProjectMapper()->save($projectEntity);
        
    }
    
    public function listProjects(){
        
        $projectEntity = new ProjectEntity();
        
        return $this->getProjectMapper()->select($projectEntity);
        
    }
    
    public function getProjectDetails($projectId){
        
        $projectEntity = new ProjectEntity();
        $projectEntity->setIdProject($projectId);
        
        $projectDetails = $this->getProjectMapper()->select($projectEntity);
        
        return $projectDetails;
        
    }
    
}

?>
