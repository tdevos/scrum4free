<?php

namespace Scrum\Mapper;

use Scrum\Entity\Task AS TaskEntity;
Use Zend\EventManager\EventManager AS EventManager;
use Zend\ServiceManager\ServiceManager AS ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface AS ServiceManagerAwareInterface;

class Task extends EventManager implements ServiceManagerAwareInterface
{
    
    protected $serviceManager;
    
    public function setServiceManager(ServiceManager $serviceManager){
        $this->serviceManager = $serviceManager;
        return $this;
    }
    
    public function getServiceManager(){
        return $this->serviceManager;
    }
    
    public function getTaskTableModel(){
        return $this->getServiceManager()->get("Scrum\Model\TaskTable");
    }
    
    function save(TaskEntity $taskEntity){
        if (is_null($taskEntity->getIdTask())) {
            return $this->getTaskTableModel()->insert($taskEntity->getNotNull());
        } else {
            return $this->getTaskTableModel()->update($taskEntity->getNotNull(),array("id_story" => $taskEntity->getIdStory()));
        }
    }
    
    function select(TaskEntity $taskEntity){
        
        $where = array();
        
        if(!is_null($taskEntity->getIdTask()))
            $where["id_task"] = $taskEntity->getIdTask ();
        if(!is_null($taskEntity->getFkIdStory()))
            $where["fk_id_story"] = $taskEntity->getFkIdStory ();
        if(!is_null($taskEntity->getName()))
            $where["name"] = $taskEntity->getName ();
        if(!is_null($taskEntity->getDescription()))
            $where["description"] = $taskEntity->getDescription ();
        if(!is_null($taskEntity->getStatus()))
            $where["status"] = $taskEntity->getStatus ();
        if(!is_null($taskEntity->getTime()))
            $where["time"] = $taskEntity->getTime ();
        if(!is_null($taskEntity->getActors()))
            $where["actors"] = $taskEntity->getActors ();
        
        return $this->getTaskTableModel()->select($where);
        
    }
    

    public function remove(TaskEntity $taskEntity){
        return $this->getTaskTableModel()->delete($taskEntity->getIdTask());
    }
    
    public function fetchOne(TaskEntity $taskEntity){
        $result = $this->getTaskTableModel()->fetchOneByIdTask($taskEntity->getIdTask());
        $resultArray = $result->current();
        
        $taskEntity->setActors($resultArray["actors"]);
        $taskEntity->setDescription($resultArray["description"]);
        $taskEntity->setStatus($resultArray["state"]);
        $taskEntity->setTime($resultArray["time"]);
        $taskEntity->setTitle($resultArray["title"]);
        
        return $taskEntity;
    }
    
    public function fetchAll(){
        return $this->getTaskTableModel()->fetchAll();
    }
    
}