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
}
