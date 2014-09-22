<?php

class Application_Form_Site extends Application_Form_Form
{

    public function init()
    {
        $this->setName('site')
            ->setAction('/adminpanel/sites/add/')
            ->setMethod('post');

        $category = new Application_Form_Element_Select('category_id');
        $category->setLabel('Категория')
            ->setRequired(true);

        $pub = new Zend_Form_Element_Hidden('public');

        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Заголовок')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim');

        $id = new Zend_Form_Element_Text('id');
        $id->setLabel('Алиас')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim');

        $text = new Application_Form_Element_Wysiwyg('description');
        $text->setLabel('Текст')
            ->setRequired(true);

        // создаём кнопку submit
        $submit = new Application_Form_Element_Submit('save');
        $submit->setLabel('Сохранить');

        $this->addElements(array($category, $title,$pub, $id, $text, $submit));

        $this->prepare();
    }

    public function prepare()
    {
        $category = $this->getElement('category_id');
        $model = new Models_Categories_Mapper();
        $categories = $model->getAll();
        foreach ($categories as $t) {
            $category->addMultiOption($t->id, $t->title);
        }
    }

}