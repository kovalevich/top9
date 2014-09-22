<?php

class Application_Form_Search extends Application_Form_Form
{

    public function init()
    {
        $this->setName('search');
        $this->setAction('/catalog/search');
        $this->setMethod('post');
        
        $word = new Zend_Form_Element_Text('word');
        $word->setLabel($this->getTranslator()->translate('zapros'))
        ->setRequired(true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim');
        
        // создаём кнопку submit
        $submit = new Zend_Form_Element_Submit('search');
        $submit->setLabel($this->getTranslator()->translate('search'));
        
        $this->addElements(array($word, $submit));
    }


}