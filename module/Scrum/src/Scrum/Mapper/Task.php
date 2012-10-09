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

    public function remove(TaskEntity $taskEntity){
        return $this->getTaskTableModel()->delete($taskEntity->getIdTask());
    }
    
    public function add(TaskEntity $taskEntity){
        return $this->getTaskTableModel()->add(
                    $taskEntity->getTitle(),
                    $taskEntity->getDescription(),
                    $taskEntity->getTime(),
                    $taskEntity->getActors(),
                    $taskEntity->getStatus()
                );
    }
    
    public function edit(TaskEntity $taskEntity){
        return $this->getTaskTableModel()->edit(
                    $taskEntity->getIdTask(),
                    $taskEntity->getTitle(),
                    $taskEntity->getDescription(),
                    $taskEntity->getTime(),
                    $taskEntity->getActors(),
                    $taskEntity->getStatus()
                );
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