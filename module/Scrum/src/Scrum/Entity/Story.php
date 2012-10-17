<?php

namespace Scrum\Entity;

class Story {
    
    protected $idStory;
    protected $fkIdProject;
    protected $fkIdSprint;
    protected $name;
    protected $description;
    protected $status;
    
    public function getIdStory(){
        return $this->idStory;
    }
    
    public function setIdStory($idStory){
        $this->idStory = $idStory;
    }
    
    public function getFkIdProject(){
        return $this->fkIdProject;
    }
    
    public function setFkIdProject($fkIdProject){
        $this->fkIdProject = $fkIdProject;
    }
    
    public function getFkIdSprint(){
        return $this->fkIdSprint;
    }
    
    public function setFkIdSprint($fkIdSprint){
        $this->fkIdSprint = $fkIdSprint;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        $this->name = $name;
    }
    
    public function getDescription(){
        return $this->description;
    }
    
    public function setDescription($description){
        $this->description = $description;
    }
    
    public function getStatus(){
        return $this->status;
    }
    
    public function setStatus($status){
        $this->status = $status;
    }
    
    public function getNotNull(){
        $array = array();
        
        if($this->getIdStory() != null)
            $array["id_story"] = $this->getIdStory();
        
        if($this->getFkIdProject() != null)
            $array["fk_id_project"] = $this->getFkIdProject();
        
        if($this->getFkIdSprint() != null)
            $array["fk_id_sprint"] = $this->getFkIdSprint();
        
        if($this->getDescription() != null)
            $array["description"] = $this->getDescription();
        
        if($this->getName() != null)
            $array["name"] = $this->getName();
        
        if($this->getStatus() != null)
            $array["status"] = $this->getStatus();
        
        return $array;
        
    }
    
}

?>
