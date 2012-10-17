<?php

namespace Scrum\Service;

Use Zend\EventManager\EventManager AS EventManager;
use Zend\ServiceManager\ServiceManagerAwareInterface AS ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager AS ServiceManager;
use Scrum\Entity\Story AS StoryEntity;

class Story extends EventManager implements ServiceManagerAwareInterface {

    protected $serviceManager;
    protected $storyMapper;

    public function setServiceManager(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function getStoryMapper() {
        if (null === $this->storyMapper) {
            $this->storyMapper = $this->getServiceManager()->get("scrum_story_mapper");
        }
        return $this->storyMapper;
    }

    /***************************************************************************************************************** */
    
    public function saveFromPost(\ArrayObject $formData, $idStory = null){
        
        $storyEntity = new StoryEntity();
        
        if(!is_null($idStory))
            $storyEntity->setIdStory ($idStory);
        
        $storyEntity->setName($formData->name);
        $storyEntity->setDescription($formData->description);
        $storyEntity->setStatus($formData->status);
        $storyEntity->setFkIdProject($formData->fk_id_project);
        
        $this->getStoryMapper()->save($storyEntity);
        
    }
    
    public function listStories(){
        
        $storyEntity = new StoryEntity();
        
        return $this->getStoryMapper()->select($storyEntity);
        
    }
    
    public function getListOrphanStoriesWithProjectId($projectId){
        
        $storyEntity = new StoryEntity();
        $storyEntity->setFkIdProject($projectId);
        $storyEntity->setFkIdSprint("NULL");
        
        return $this->getStoryMapper()->select($storyEntity);
        
    }
    
    public function getListStoriesWithSprintId($sprintId){
        
        $storyEntity = new StoryEntity();
        $storyEntity->setFkIdSprint($sprintId);
        
        return $this->getStoryMapper()->select($storyEntity);
        
    }
    
    public function linkToSprint($sprintId, $storyId){
        
        $storyEntity = new StoryEntity();
        $storyEntity->setIdStory($storyId);
        $storyEntity->setFkIdSprint($sprintId);
        
        return $this->getStoryMapper()->save($storyEntity);
        
    }
    
}

?>
