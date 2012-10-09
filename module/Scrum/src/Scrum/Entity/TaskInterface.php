<?php

namespace Scrum\Entity;

interface TaskInterface
{
    
    public function setTitle($title);
    public function getTitle();
    
    public function setDescription($description);
    public function getDescription();
    
    public function setTime($time);
    public function getTime();
    
    public function setActors($actors);
    public function getActors();
    
    public function setStatus($status);
    public function getStatus();
    
}