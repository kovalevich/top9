<?php

class Application_Form_Element_Checkbox extends Zend_Form_Element_Checkbox
{
    
    public function init()
    {
        $this->helper = 'checkbox';
        $this->viewScript = 'formelements/checkbox.phtml';
        $this->setDecorators(array('ViewScript'));
        parent::init();
    }
}

?>