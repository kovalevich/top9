<?php

class Application_Form_EditPassword extends Application_Form_Form
{

    public function init()
    {
        $this->setName('registration');
        $this->setAction('/room/editpassword');
        
        // сообщение о незаполненном поле
        $isEmptyMessage = $this->getTranslator()->translate('emptymessage');
        
        $pass = new Zend_Form_Element_Password('password');
        $pass->setLabel($this->getTranslator()->translate('new password'))
        ->setRequired(true)
        ->addValidator('NotEmpty');
        
        $passconfirm = new Zend_Form_Element_Password('password_confirm');
        $passconfirm->setLabel($this->getTranslator()->translate('password confirm'))
        ->setRequired(true)
        ->addValidator('NotEmpty')
        ->addPrefixPath('Classes_Validator', 'Validator', 'validate')
        ->addValidator('PasswordConfirm');
        
        
        // создаём кнопку submit
        $submit = new Zend_Form_Element_Submit('save');
        $submit->setLabel($this->getTranslator()->translate('save'));
        
        $this->addElements(array($pass, $passconfirm, $submit));
        
        $this->setMethod('post');
    }


}

