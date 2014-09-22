<?php

class Application_Form_Element_Submit extends Zend_Form_Element_Submit
{
    
    public function init()
    {
        $this->helper = 'submit';
        $this->viewScript = 'formelements/submit.phtml';
        $this->setDecorators(array('ViewScript'));
        parent::init();
    }
}

?>