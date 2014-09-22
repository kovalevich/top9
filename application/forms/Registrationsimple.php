<?php

class Application_Form_Registrationsimple extends Application_Form_Form
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
        
        // создаём кнопку submit
        $submit = new Zend_Form_Element_Submit('registration');
        $submit->setLabel($this->getTranslator()->translate('registration'));
        
        $this->addElements(array($mail, $fio, $phone, $city, $submit));

        $this->setMethod('post');
    }
    

}

