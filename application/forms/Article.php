<?php

class Application_Form_Article extends Application_Form_Form
{

    public function init()
    {
        $this->setName('article')
        ->setAction('/adminpanel/articles/add/')
        ->setMethod('post');
        
        $category = new Application_Form_Element_Select('category_id');
        $category->setLabel('Категория')
        ->setRequired(true);
        
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Заголовок')
        ->setRequired(true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim');

        $id = new Zend_Form_Element_Text('id');
        $id->setLabel('Алиас')
            ->addFilter('StripTags')
            ->addFilter('StringTrim');
        
        $text = new Application_Form_Element_Wysiwyg('text');
        $text->setLabel('Текст')
            ->setRequired(true);
        
        $metatitle = new Zend_Form_Element_Text('meta_title');
        $metatitle->setLabel('Заголовок (meta)')
        ->addFilter('StripTags')
        ->addFilter('StringTrim');
        
        $keywords = new Zend_Form_Element_Text('meta_keywords');
        $keywords->setLabel('Ключевые слова (meta)')
        ->addFilter('StripTags')
        ->addFilter('StringTrim');

        $pub = new Zend_Form_Element_Hidden('public');
        
        $description = new Zend_Form_Element_Textarea('meta_description');
        $description->setLabel('Описание (meta)')
        ->addFilter('StripTags')
        ->addFilter('StringTrim');
        
        // создаём кнопку submit
        $submit = new Application_Form_Element_Submit('save');
        $submit->setLabel('Сохранить');
        
        $this->addElements(array($category, $title, $id, $text, $pub ,$metatitle, $keywords, $description, $submit));
        
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