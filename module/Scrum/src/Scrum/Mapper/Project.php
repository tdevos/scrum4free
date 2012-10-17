<?php

namespace Scrum\Mapper;

use Scrum\Entity\Project AS ProjectEntity;
Use Zend\EventManager\EventManager AS EventManager;
use Zend\ServiceManager\ServiceManager AS ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface AS ServiceManagerAwareInterface;
use Zend\Db\ResultSet\ResultSet AS ResultSet;

class Project extends EventManager implements ServiceManagerAwareInterface {

    protected $serviceManager;
    protected $projectTable;

    public function setServiceManager(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function getProjectTableModel() {
        if (null === $this->projectTable) {
            $this->projectTable = $this->getServiceManager()->get("Scrum\Model\ProjectTable");
        }
        return $this->projectTable;
    }

    /*     * *************************************************************************************************************** */

    public function delete(ProjectEntity $projectEntity) {
        return $this->getProjectTableModel()->delete(array("id_project" => $projectEntity->getIdProject()));
    }

    public function save(ProjectEntity $projectEntity) {
        if (is_null($projectEntity->getIdProject())) {
            return $this->getProjectTableModel()->insert(array(
                        "name" => $projectEntity->getName(),
                        "description" => $projectEntity->getDescription()
                    ));
        } else {
            return $this->getProjectTableModel()->update(array(
                        "name" => $projectEntity->getName(),
                        "description" => $projectEntity->getDescription()
                    ), array("id_project" => $projectEntity->getIdProject()));
        }
    }

    public function select(ProjectEntity $projectEntity) {

        $where = array();

        if (!is_null($projectEntity->getIdProject()))
            $where["id_project"] = $projectEntity->getIdProject();
        if (!is_null($projectEntity->getName()))
            $where["name"] = $projectEntity->getName();
        if (!is_null($projectEntity->getDescription()))
            $where["description"] = $projectEntity->getDescription();

        $result = $this->getProjectTableModel()->select($where);
        
        if (!is_null($projectEntity->getIdProject()))
            return $result->current();
        
        return $result;
    }

}