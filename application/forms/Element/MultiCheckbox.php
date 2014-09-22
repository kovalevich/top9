<?php

class Application_Form_Element_MultiCheckbox extends Zend_Form_Element_MultiCheckbox
{
    
    public function init()
    {
        $this->helper = 'multicheckbox';
        $this->viewScript = 'formelements/multicheckbox.phtml';
        $this->setDecorators(array('ViewScript'));
        parent::init();
    }
}

?>