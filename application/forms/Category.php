<?php

class Application_Form_Category extends Application_Form_Form
{

    public function init()
    {
        $this->setName('type');
        $this->setAction('/adminpanel/categories/add');
        $this->setMethod('post');
        
        $id = new Zend_Form_Element_Text('id');
        $id->setLabel('Алиас')
        ->setRequired(true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('Db_NoRecordExists', false, array(
        		'table'=>'categories',
        		'field'=>'id',
        ));
                
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Заголовок')
        ->setRequired(true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim');
        
        $description = new Application_Form_Element_Wysiwyg('description');
        $description->setLabel('Описание')
        ->addFilter('StripTags')
        ->addFilter('StringTrim');
        
        // создаём кнопку submit
        $submit = new Application_Form_Element_Submit('save');
        $submit->setLabel('Сохранить');
   
        $this->addElements(array($id, $title, $description, $submit));
        
    }

}