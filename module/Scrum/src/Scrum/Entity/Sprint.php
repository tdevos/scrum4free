<?php

namespace Scrum\Entity;

class Sprint {
    
    protected $idSprint;
    protected $fkIdProject;
    protected $name;
    protected $startDate;
    protected $endDate;

    public function getIdSprint(){
        return $this->idSprint;
    }
    
    public function setIdSprint($idSprint){
        $this->idSprint = $idSprint;
    }
    
    public function getFkIdProject(){
        return $this->fkIdProject;
    }
    
    public function setFkIdProject($fkIdProject){
        $this->fkIdProject = $fkIdProject;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        $this->name = $name;
    }
    
    public function getStartDate(){
        return $this->startDate;
    }
    
    public function setStartDate($startDate){
        $this->startDate = $startDate;
    }
    
    public function getEndDate(){
        return $this->endDate;
    }
    
    public function setEndDate($endDate){
        $this->endDate = $endDate;
    }
    
}

?>
