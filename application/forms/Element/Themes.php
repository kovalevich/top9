<?php

class Application_Form_Element_Themes extends Zend_Form_Element
{
    public function init()
    {
        $this->helper = 'themes';
        $this->viewScript = 'formelements/themes.phtml';
        $this->setDecorators(array('ViewScript'));
        parent::init();
    }
}

?>