<?php

namespace Scrum\Form;

use Zend\Form\Form AS Zend_Form;
use Zend\Form\Element\Text AS Input_Text;
use Zend\Form\Element\Textarea AS Input_Textarea;
use Zend\Form\Element\Submit AS Input_Submit;
use Zend\Form\Element\Date AS Input_Date;

class Sprint extends Zend_Form{
    
    function __construct($name = null) {
        parent::__construct($name);
        
        $name = new Input_Text("name");
        $name->setLabel("Name");
        $this->add($name);
        
        $start_date = new Input_Date("start_date");
        $start_date->setLabel("Start Date");
        $this->add($start_date);
        
        $end_date = new Input_Date("end_date");
        $end_date->setLabel("End Date");
        $this->add($end_date);
        
        $submit = new Input_Submit("submit");
        $submit->setValue("Save");
        $this->add($submit);
        
    }
    
}

?>
