<?php

class Application_Form_Forgot extends Application_Form_Form
{

    public function init()
    {
        $this->setName('forgot');
        $this->setAction('forgotpass');
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
        ->addValidator('EmailAddress');
        
        // создаём кнопку submit
        $submit = new Zend_Form_Element_Submit('send');
        $submit->setLabel('Сменить пароль');
        
        $this->addElements(array($mail, $submit));

        $this->setMethod('post');
    }
    

}

