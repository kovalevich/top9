<?php

class Application_Form_Registration extends Application_Form_Form
{

    public function init()
    {
        $this->setName('registration');
        $this->setAction('registration');
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);
        
        // создаём текстовый элемент
        $mail = new Zend_Form_Element_Text('email');
        
        // задаём ему label и отмечаем как обязательное поле;
        // также добавляем фильтры и валидатор с переводом
        $mail->setLabel($this->getTranslator()->translate('mail'))
        ->setRequired(true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('NotEmpty', true)
        ->addValidator('EmailAddress')
        ->addValidator('Db_NoRecordExists', false, array(
                'table'=>'users',
                'field'=>'email',
        ));
        
        // создаём текстовый элемент
        $fio = new Zend_Form_Element_Text('name');
        
        // задаём ему label и отмечаем как обязательное поле;
        // также добавляем фильтры и валидатор с переводом
        $fio->setLabel($this->getTranslator()->translate('fio'))
        ->setRequired(true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('NotEmpty');
        
        // создаём текстовый элемент
        $phone = new Zend_Form_Element_Text('phone');
        
        // задаём ему label и отмечаем как обязательное поле;
        // также добавляем фильтры и валидатор с переводом
        $phone->setLabel($this->getTranslator()->translate('phone'))
        ->setRequired(true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->setAttrib('id', 'phone')
        ->addValidator('NotEmpty');
        
        // создаём текстовый элемент
        $city = new Zend_Form_Element_Text('city');
        
        // задаём ему label и отмечаем как обязательное поле;
        // также добавляем фильтры и валидатор с переводом
        $city->setLabel($this->getTranslator()->translate('city'))
        ->setRequired(true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('NotEmpty');
        
        $isauthor = new Application_Form_Element_MultiCheckbox('isauthor');
        $isauthor->addMultiOption('prop', $this->getTranslator()->translate('isauthor'));
        
        $file = new Zend_Form_Element_File('file');
        $file->setLabel($this->getTranslator()->translate('file profile'). '. ' . $this->getTranslator()->translate('file format'))
        ->setDestination(APPLICATION_UPLOADS_DIR)
        ->addValidator('Extension', false, 'zip,rar,doc,docx,jpeg,png');
        
        $themes = new Application_Form_Element_MultiCheckbox('themes');
        
        
        // создаём кнопку submit
        $submit = new Zend_Form_Element_Submit('registration');
        $submit->setLabel($this->getTranslator()->translate('registration'));
        
        $this->addElements(array($mail, $fio, $phone, $city, $isauthor, $themes, $file, $submit));
        $this->prepare();
        $this->setMethod('post');
    }
    
    public function prepare()
    {
    	$theme = $this->getElement('themes');
    	
    	if(!$cat = Classes_Cache::get('themescategories')) {
        	$model = new Models_Themescategories_Mapper();
        	$cat = $model->getAll();
        	Classes_Cache::save($cat, 'themescategories', array('themescategories'));
    	}
    	foreach ($cat as $t) {
    		$theme->addMultiOption($t->id, $t->title, true);
    	}
    }

}

