<?php

namespace Scrum\Mapper;

use Scrum\Entity\Story AS StoryEntity;
Use Zend\EventManager\EventManager AS EventManager;
use Zend\ServiceManager\ServiceManager AS ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface AS ServiceManagerAwareInterface;

class Story extends EventManager implements ServiceManagerAwareInterface {

    protected $serviceManager;
    protected $storyTable;

    public function setServiceManager(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function getStoryTableModel() {
        if (null === $this->storyTable) {
            $this->storyTable = $this->getServiceManager()->get("Scrum\Model\StoryTable");
        }
        return $this->storyTable;
    }

    /*     * *************************************************************************************************************** */

    public function delete(StoryEntity $storyEntity) {
        return $this->getStoryTableModel()->delete(array("id_story" => $storyEntity->getIdStory()));
    }

    public function save(StoryEntity $storyEntity) {
        if (is_null($storyEntity->getIdStory())) {
            return $this->getStoryTableModel()->insert($storyEntity->getNotNull());
        } else {
            return $this->getStoryTableModel()->update($storyEntity->getNotNull(),array("id_story" => $storyEntity->getIdStory()));
        }
    }

    public function select(StoryEntity $storyEntity) {

        $where = array();
        
        if (!is_null($storyEntity->getIdStory()))
            $where["id_story"] = $storyEntity->getIdStory();
        if (!is_null($storyEntity->getFkIdProject()))
            $where["fk_id_project"] = $storyEntity->getFkIdProject();
        if (!is_null($storyEntity->getFkIdSprint())){
            if($storyEntity->getFkIdSprint() == "NULL")
                array_push($where, new \Zend\Db\Sql\Predicate\IsNull('fk_id_sprint'));
            else
                $where["fk_id_sprint"] = $storyEntity->getFkIdSprint();
        }
        if (!is_null($storyEntity->getName()))
            $where["name"] = $storyEntity->getName();
        if (!is_null($storyEntity->getDescription()))
            $where["description"] = $storyEntity->getDescription();
        
        // @todo : HAVE TO CHANGE IT
        
        $result = $this->getStoryTableModel()->select($where);
        
        if (!is_null($storyEntity->getIdStory()))
            return $result->current();
        
        return $result;
    }
    

}