<?php

namespace Scrum\Model;

use Zend\Db\TableGateway\AbstractTableGateway AS AbstractTableGateway;
use Zend\Db\Adapter\Adapter AS Adapter;

class StoryTable extends AbstractTableGateway{
    
    protected $table = "story";

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->initialize();
    }
      
}
