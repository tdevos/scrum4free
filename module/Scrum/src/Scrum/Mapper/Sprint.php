<?php

namespace Scrum\Mapper;

use Scrum\Entity\Sprint AS SprintEntity;
Use Zend\EventManager\EventManager AS EventManager;
use Zend\ServiceManager\ServiceManager AS ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface AS ServiceManagerAwareInterface;

class Sprint extends EventManager implements ServiceManagerAwareInterface {

    protected $serviceManager;
    protected $sprintTable;

    public function setServiceManager(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function getSprintTableModel() {
        if (null === $this->sprintTable) {
            $this->sprintTable = $this->getServiceManager()->get("Scrum\Model\SprintTable");
        }
        return $this->sprintTable;
    }

    /*     * *************************************************************************************************************** */

    public function delete(SprintEntity $sprintEntity) {
        return $this->getSprintTableModel()->delete(array("id_sprint" => $sprintEntity->getIdSprint()));
    }

    public function save(SprintEntity $sprintEntity) {
        if (is_null($sprintEntity->getIdSprint())) {
            return $this->getSprintTableModel()->insert(array(
                        "name" => $sprintEntity->getName(),
                        "fk_id_project" => $sprintEntity->getFkIdProject(),
                        "start_date" => $sprintEntity->getStartDate(),
                        "end_date" => $sprintEntity->getEndDate()
                    ));
        } else {
            return $this->getSprintTableModel()->update(array(
                        "name" => $sprintEntity->getName(),
                        "fk_id_project" => $sprintEntity->getFkIdProject(),
                        "start_date" => $sprintEntity->getStartDate(),
                        "end_date" => $sprintEntity->getEndDate()
                    ), array("id_sprint" => $sprintEntity->getIdSprint()));
        }
    }

    public function select(SprintEntity $sprintEntity) {

        $where = array();

        if (!is_null($sprintEntity->getIdSprint()))
            $where["id_sprint"] = $sprintEntity->getIdSprint();
        if (!is_null($sprintEntity->getFkIdProject()))
            $where["fk_id_project"] = $sprintEntity->getFkIdProject();
        if (!is_null($sprintEntity->getName()))
            $where["name"] = $sprintEntity->getName();
        if (!is_null($sprintEntity->getStartDate()))
            $where["start_date"] = $sprintEntity->getStartDate();
        if (!is_null($sprintEntity->getEndDate()))
            $where["end_date"] = $sprintEntity->getEndDate();

        $oui = new \Scrum\Model\SprintTable();
        $result = $oui->getAdapter()->query("select * from sprint")->execute($parameters);
        
//        $result = $this->getSprintTableModel()->select($where);
        
        if (!is_null($sprintEntity->getIdSprint()))
            return $result->current();
        
        return $result;
    }

}