<?php

class Application_Form_Element_Date extends Zend_Form_Element_Text
{
    
    public function init()
    {
        $this->viewScript = 'formelements/date.phtml';
        $this->setDecorators(array('ViewScript'));
        parent::init();
    }
}

?>