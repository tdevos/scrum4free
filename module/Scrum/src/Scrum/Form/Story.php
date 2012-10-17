<?php

namespace Scrum\Form;

use Zend\Form\Form AS Zend_Form;
use Zend\Form\Element\Text AS Input_Text;
use Zend\Form\Element\Textarea AS Input_Textarea;
use Zend\Form\Element\Select AS Input_Select;
use Zend\Form\Element\Submit AS Input_Submit;

class Story extends Zend_Form{
    
    function __construct($name = null) {
        parent::__construct($name);
        
        $name = new Input_Text("name");
        $name->setLabel("Name");
        $this->add($name);
        
        $description = new Input_Textarea("description");
        $description->setLabel("Description");
        $this->add($description);
        
        $status = new Input_Select("status");
        $status->setValueOptions(array(
            1 => "Wait",
            2 => "Started",
            3 => "Done"
        ));
        $this->add($status);
        
        $submit = new Input_Submit("submit");
        $submit->setValue("Save");
        $this->add($submit);
        
    }
    
}

?>
