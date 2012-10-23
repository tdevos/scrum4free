<?php

namespace Scrum\Service;

Use Zend\EventManager\EventManager AS EventManager;
use Zend\ServiceManager\ServiceManagerAwareInterface AS ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager AS ServiceManager;
use Scrum\Entity\Task AS TaskEntity;

class Task extends EventManager implements ServiceManagerAwareInterface{
    
    protected $serviceManager;
    protected $taskMapper;

    public function setServiceManager(ServiceManager $serviceManager){
        
        $this->serviceManager = $serviceManager;
        return $this;
        
    }
    
    public function getServiceManager(){
        return $this->serviceManager;
    }
    
    public function getTaskMapper(){
        if(null === $this->taskMapper){
            $this->taskMapper = $this->getServiceManager()->get("scrum_task_mapper");
        }
        return $this->taskMapper;
    }

    /***************************************************************************************************************** */
    
    public function saveFromPost(\ArrayObject $postData, $idTask = null) {
        
        $taskEntity = new TaskEntity();
        
        if(!is_null($idTask))
            $taskEntity->setIdTask($idTask);
        
        if(!is_null($postData->fk_id_story))
            $taskEntity->setFkIdStory ($postData->fk_id_story);
        
        $taskEntity->setName($postData->name);
        $taskEntity->setDescription($postData->description);
        $taskEntity->setStatus($postData->status);
        $taskEntity->setTime($postData->time);
        $taskEntity->setActors($postData->actors);
        
        $this->getTaskMapper()->save($taskEntity);
        
    }
    
    public function listTasksWithStoryId($storyId){
        
        $taskEntity = new TaskEntity();
        $taskEntity->setFkIdStory($storyId);
        
        return $this->getTaskMapper()->select($taskEntity);
        
    }
    
    public function get($id){
        
        $taskEntity = new TaskEntity();
        $taskEntity->setIdTask($id);
        
        $taskMapper = $this->getTaskMapper();
        return $taskMapper->fetchOne($taskEntity);
        
    }
    
    public function save(TaskEntity $taskEntity){
        $taskMapper = $this->getTaskMapper();
        if($taskEntity->getIdTask() != null)
        return $taskMapper->edit($taskEntity);
        else
        return $taskMapper->add($taskEntity);
    }
    
    public function changeStatus($idTask, $idStatus){
        $taskEntity = $this->get($idTask);
        $taskEntity->setStatus($idStatus);
        return $this->save($taskEntity);
    }
    
    public function getAllByStatus(){
        $taskmapper = $this->getTaskMapper();
        $allTasks = $taskmapper->fetchAll();
        $allTaskByColumn = array();
        foreach ($allTasks as $task) {
            if(!isset($allTaskByColumn[$task->status]))
                $allTaskByColumn[$task->status] = array();
            array_push($allTaskByColumn[$task->status], $task);
        }
        return $allTaskByColumn;
    }
    
    public function delete($idTask){
        $taskmapper = $this->getTaskMapper();
        $taskEntity = new TaskEntity();
        $taskEntity->setIdTask($idTask);
        if($taskEntity->getIdTask() != null)
            return $taskmapper->remove($taskEntity);
        else
            return 0;
    }
    
}

?>
