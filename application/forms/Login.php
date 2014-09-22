<?php

class Application_Form_Login extends Application_Form_Form
{
    public function init()
    {
    	// указываем имя формы
    	$this->setName('login');
    	$this->setAction('/auth/login');

    	// создаём текстовый элемент
    	$username = new Zend_Form_Element_Text('email');

    	// задаём ему label и отмечаем как обязательное поле;
    	// также добавляем фильтры и валидатор с переводом
    	$username->setLabel('email')
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty');

    	// создаём элемент формы для пароля
    	$password = new Zend_Form_Element_Password('password');

    	// задаём ему label и отмечаем как обязательное поле;
    	// также добавляем фильтры и валидатор с переводом
    	$password->setLabel('Пароль')
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty');
    	// создаём кнопку submit
    	$submit = new Zend_Form_Element_Submit('login');
    	$submit->setLabel('Войти');

    	$this->addElements(array($username, $password, $submit));

    	$this->setMethod('post');
    }

}

