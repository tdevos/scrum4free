<?php

namespace Scrum\Form;

use Zend\Form\Form AS Zend_Form;
use Zend\Form\Element\Select AS Input_Select;
use Zend\Form\Element\Submit AS Input_Submit;

class LinkStorySprint extends Zend_Form {

    function __construct($name = null) {

        parent::__construct($name);

        $selectStory = new Input_Select("fk_id_story");
        $this->add($selectStory);
        
        $submit = new Input_Submit("submit");
        $submit->setValue("Save");
        $this->add($submit);
        
    }

}

?>
