<?php

namespace Scrum\Form;

use Zend\Form\Form AS Zend_Form;
use Zend\Form\Element\Text AS Input_Text;
use Zend\Form\Element\Textarea AS Input_Textarea;
use Zend\Form\Element\Submit AS Input_Submit;

class Task extends Zend_Form{
    
    function __construct($name = null) {
        parent::__construct($name);
        
        $name = new Input_Text("name");
        $name->setLabel("Name");
        $this->add($name);
        
        $description = new Input_Textarea("description");
        $description->setLabel("Description");
        $this->add($description);
        
        $time = new Input_Text("time");
        $time->setLabel("Time");
        $this->add($time);
        
        $actors = new Input_Text("actors");
        $actors->setLabel("Actors");
        $this->add($actors);
        
        $submit = new Input_Submit("submit");
        $submit->setValue("Add");
        $this->add($submit);
        
    }
    
}

?>
