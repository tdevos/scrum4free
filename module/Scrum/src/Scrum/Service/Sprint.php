<?php

namespace Scrum\Service;

Use Zend\EventManager\EventManager AS EventManager;
use Zend\ServiceManager\ServiceManagerAwareInterface AS ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager AS ServiceManager;
use Scrum\Entity\Sprint AS SprintEntity;

class Sprint extends EventManager implements ServiceManagerAwareInterface {

    protected $serviceManager;
    protected $sprintMapper;

    public function setServiceManager(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function getSprintMapper() {
        if (null === $this->sprintMapper) {
            $this->sprintMapper = $this->getServiceManager()->get("scrum_sprint_mapper");
        }
        return $this->sprintMapper;
    }

    /***************************************************************************************************************** */
    
    public function saveFromPost(\ArrayObject $formData, $idSprint){
        
        $sprintEntity = new SprintEntity();
        
        if(!is_null($idSprint))
            $sprintEntity->setIdSprint ($idSprint);
        
        $sprintEntity->setName($formData->name);
        $sprintEntity->setFkIdProject($formData->fk_id_project);
        $sprintEntity->setStartDate($formData->start_date);
        $sprintEntity->setEndDate($formData->end_date);
        
        $this->getSprintMapper()->save($sprintEntity);
        
    }
    
    public function listSprints(){
        
        $sprintEntity = new SprintEntity();
        
        return $this->getSprintMapper()->select($sprintEntity);
        
    }
    
    
    public function getListSprintsWithProjectId($projectId){
        
        $storyEntity = new SprintEntity();
        $storyEntity->setFkIdProject($projectId);
        
        return $this->getSprintMapper()->select($storyEntity);
        
    }
    
    public function getSprintDetails($sprintId){
        
        $sprintEntity = new SprintEntity();
        $sprintEntity->setIdSprint($sprintId);
        
        return $this->getSprintMapper()->select($sprintEntity);
        
    }
}

?>
