<?php

class Application_Form_Element_Text extends Zend_Form_Element_Select
{
    
    public function init()
    {
        $this->helper = 'text';
        $this->viewScript = 'formelements/text.phtml';
        $this->setDecorators(array('ViewScript'));
        parent::init();
    }
}

?>