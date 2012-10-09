<?php

namespace Scrum\Model;

use Zend\Db\TableGateway\AbstractTableGateway AS AbstractTableGateway;
use Zend\Db\Adapter\Adapter AS Adapter;

class TaskTable extends AbstractTableGateway{
    
    protected $table = "task";

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    public function fetchAll(){
        return parent::select();
    }
    
    public function fetchOneByIdTask($idTask){
        return parent::select(array("id_task" => $idTask));
    }
    
    public function add($title, $description, $time, $actors, $state){
        $set = array(
                "title" => $title, 
                "description" => $description, 
                "time" => $time, 
                "actors" => $actors, 
                "status" => $state
            );
        return parent::insert($set);
    }
    
    public function edit($idTask, $title, $description, $time, $actors, $status){
        $set = array(
                "title" => $title, 
                "description" => $description, 
                "time" => $time, 
                "actors" => $actors, 
                "status" => $status
            );
        return parent::update($set, array("id_task" => $idTask));
    }
    
    public function delete($idTask) {
        return parent::delete(array("id_task" => $idTask));
    }  
}
