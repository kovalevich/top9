<?php

class Application_Form_Univer extends Application_Form_Form
{
    public function init()
    {
    	$this->setName('univer');
    	$this->setMethod('post');

        $id = new Zend_Form_Element_Text('id');
        $id->setLabel('name')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim');

    	$name = new Zend_Form_Element_Text('name');
    	$name->setLabel('name')
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim');
    	
    	$full_name = new Zend_Form_Element_Text('full_name');
    	$full_name->setLabel('full name')
    	->setRequired(true)
    	->setAttrib('size', 100)
    	->addFilter('StripTags')
    	->addFilter('StringTrim');

    	$description = new Zend_Form_Element_Textarea('description');
    	$description->setLabel('description')
    	->setAttrib('rows', 10);
    	
    	$id = new Zend_Form_Element_Hidden('id');

    	$submit = new Zend_Form_Element_Submit('save');
    	$submit->setLabel('save');

    	$this->addElements(array($id,$name, $full_name, $description, $submit, $id));
    }

}