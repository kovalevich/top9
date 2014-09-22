<?php

class Application_Form_City extends Application_Form_Form
{
    public function init()
    {
    	// указываем имя формы
    	$this->setName('city');
    	$this->setMethod('post');

    	$name = new Zend_Form_Element_Text('name');
    	$name->setLabel('b')
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim');

    	$description = new Zend_Form_Element_Textarea('description');
    	$description->setLabel('d')
    	->setAttrib('rows', 10);
    	
    	$id = new Zend_Form_Element_Hidden('id');

    	$submit = new Zend_Form_Element_Submit('save');
    	$submit->setLabel('v');

    	$this->addElements(array($name, $description, $submit, $id));
    }

}