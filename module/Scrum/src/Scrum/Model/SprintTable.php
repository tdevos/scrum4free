<?php

namespace Scrum\Model;

use Zend\Db\TableGateway\AbstractTableGateway AS AbstractTableGateway;
use Zend\Db\Adapter\Adapter AS Adapter;

class SprintTable extends AbstractTableGateway{
    
    protected $table = "sprint";

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->initialize();
    }
      
}
