<?php

namespace Scrum\Entity;

class Task implements TaskInterface{
    
    protected $id_task;
    protected $title;
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
    
    public function setTitle($title){
        $this->title = $title;
    }
    public function getTitle(){
        return $this->title;
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
        
}