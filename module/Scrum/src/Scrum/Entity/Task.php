<?php

namespace Scrum\Entity;

class Task{
    
    protected $id_task;
    protected $fk_id_story;
    protected $name;
    protected $description;
    protected $time;
    protected $actors;
    protected $status;

    public function setIdTask($id_task){
        $this->id_task = $id_task;
    }
    public function getIdTask(){
        return $this->id_task;
    }
    
    public function setFkIdStory($idStory){
        $this->fk_id_story = $idStory;
    }
    
    public function getFkIdStory(){
        return $this->fk_id_story;
    }
    
    public function setName($name){
        $this->name = $name;
    }
    public function getName(){
        return $this->name;
    }
    
    public function setDescription($description){
        $this->description = $description;
    }
    public function getDescription(){
        return $this->description;
    }
    
    public function setTime($time){
        $this->time = $time;
    }
    public function getTime(){
        return $this->time;
    }
    
    public function setActors($actors){
        $this->actors = $actors;
    }
    public function getActors(){
        return $this->actors;
    }
    
    public function setStatus($status){
        $this->status = $status;
    }
    
    public function getStatus(){
        return $this->status;
    }
    
    public function getNotNull(){
        
        $array = array();
        
        if($this->getIdTask() != null)
            $array["id_task"] = $this->getIdTask ();
        
        if($this->getFkIdStory() != null)
            $array["fk_id_story"] = $this->getFkIdStory ();
        
        if($this->getDescription() != null)
            $array["description"] = $this->getDescription ();
        
        if($this->getName() != null)
            $array["name"] = $this->getName ();
        
        if($this->getActors() != null)
            $array["actors"] = $this->getActors ();
        
        if($this->getStatus() != null)
            $array["status"] = $this->getStatus ();
        
        if($this->getTime() != null)
            $array["time"] = $this->getTime ();
        
        return $array;
        
    }
        
}