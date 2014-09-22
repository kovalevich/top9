<?php

class Application_Form_File extends Application_Form_Form
{

    public function init()
    {
        $this->setName('file');
        $this->setMethod('post');
        
        $file = new Zend_Form_Element_File('file');
        $file->setLabel('Файл в формате .zip, .rar, .doc, .docx')
        ->setDestination(APPLICATION_UPLOADS_DIR)
        ->setRequired(true)
        ->addValidator('Extension', false, 'zip,rar,doc,docx');
        
        // создаём кнопку submit
        $submit = new Zend_Form_Element_Submit('load');
        $submit->setLabel($this->getTranslator()->translate('load'));  
        
        $this->addElements(array($file, $submit));
    }


}