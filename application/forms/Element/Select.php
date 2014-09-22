<?php

class Application_Form_Element_Select extends Zend_Form_Element_Select
{
    
    public function init()
    {
        $this->helper = 'select';
        $this->viewScript = 'formelements/select.phtml';
        $this->setDecorators(array('ViewScript'));
        parent::init();
    }
}

?>