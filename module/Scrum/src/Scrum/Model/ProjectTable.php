<?php

namespace Scrum\Model;

use Zend\Db\TableGateway\AbstractTableGateway AS AbstractTableGateway;
use Zend\Db\Adapter\Adapter AS Adapter;

class ProjectTable extends AbstractTableGateway{
    
    protected $table = "project";

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
}
