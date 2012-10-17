<?php

namespace Scrum\Entity;

class Project {
    
    protected $idProject;
    protected $name;
    protected $description;
    
    public function setIdProject($idProject){
        $this->idProject = $idProject;
    }
    
    public function getIdProject(){
        return $this->idProject;
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
    
}

?>
