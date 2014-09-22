<?php

class ArticlesController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->is_catalog = true;
    }

    public function indexAction()
    {
        if(!$categories = Classes_Cache::get('categories')){
            $model = new Models_Categories_Mapper();
            $categories = $model->getAll();
            Classes_Cache::save($categories, 'categories', array('categories', 'articles'));
        }
        $this->view->categories = $categories;

        if(!$articles = Classes_Cache::get('newarticles')){
            $model_articles = new Models_Articles_Mapper();
            $articles = $model_articles->getNew();
            Classes_Cache::save($articles, 'newarticles', array('articles'));
        }
        $this->view->articles = $articles;
    }

    public function addAction()
    {
        $form = new Application_Form_Article();
        $model = new Models_Articles_Mapper();

        if(!$categories = Classes_Cache::get('categories')){
            $model_categories = new Models_Categories_Mapper();
            $categories = $model_categories->getAll();
            Classes_Cache::save($categories, 'categories', array('categories', 'articles'));
        }
        $this->view->categories = $categories;

        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $model->getRow();
                $model->fill($form->getValues());
                $model->id = !empty($model->id) ? $model->id : Classes_IdGenerator::generate();
                $model->meta_title = !empty($model->meta_title) ? $model->meta_title : $model->title;
                $model->meta_description = !empty($model->meta_description) ? $model->meta_description : 'Каталог статей. Продвижение статьями. Статейная оптимизация';
                $model->meta_keywords = !empty($model->meta_keywords) ? $model->meta_keywords : 'каталог статей, статьи, продвижение сайтов';
                $model->created = date('Y-m-d H:i:s');
                $model->modified = date('Y-m-d H:i:s');
                $model->public = 0;
                $model->save();

                $model_categories = new Models_Categories_Mapper($model->category_id);
                if ($model_categories->id) {
                    $model_categories->count++;
                    $model_categories->save();
                }
                $this->view->message = '<strong>Поздравляем!</strong> Ваша статья сохранена. Обращаем ваше внимание, что статья может быть удалена администратором, если вы нарушили наши простые правила!';
            }
            else {
                $this->view->errors = '<strong>Ошибка!</strong> Все поля формы должны быть заполненны!';
            }
        }
        $this->view->form = $form;
    }

    public function articleAction()
    {
        if (true && $id = $this->_request->getParam('id', false)) {
            $cache_id = preg_replace('[-]', '_', $id);
            if (!$article = Classes_Cache::get('article' . $cache_id)) {
                $model = new Models_Articles_Mapper($id);
                $article = $model->getArticle();
                Classes_Cache::save($article, 'article'.$cache_id, array('articles'));
            }
            if ($article->id){
                $this->view->article = $article;
            }
            else {
                throw new Zend_Controller_Dispatcher_Exception('Такой страницы нет на сайте');
            }
        }
        else {
            throw new Zend_Controller_Dispatcher_Exception('Такой страницы нет на сайте');
        }
    }

    public function categoryAction()
    {
        $id = $this->_request->getParam('id');
        if ($id) {
            
            if (!$category = Classes_Cache::get('category' . $id)) {
            	$model = new Models_Categories_Mapper($id);
            	$category = $model->getCategory();
            	Classes_Cache::save($category, 'category'.$id);
            }
        	if ($category->id) {
                $page = $this->_request->getParam('page', 1);
        	    if (!$articles = Classes_Cache::get('articlesfromcat' . $category->id . 'page' . $page)) {
                    $model = new Models_Articles_Mapper();
        	    	$paginator = $model->getPaginator($page, $category->id);
                    $articles = $model->convertRows($paginator);
        	    	Classes_Cache::save($articles, 'articlesfromcat' . $category->id . 'page' . $page, array('articles'));
                    Classes_Cache::save($paginator->__toString(), 'paginatorarticlesfromcat' . $category->id . 'page' . $page, array('articles'));
        	    }

                $this->view->paginator = Classes_Cache::get('paginatorarticlesfromcat' . $category->id . 'page' . $page);
        		$this->view->articles = $articles;
        		$this->view->category = $category;
        	}
        	else {
        		throw new Zend_Controller_Dispatcher_Exception('Такой страницы нет на сайте');
        	}
        }
        else {
        	throw new Zend_Controller_Dispatcher_Exception('Такой страницы нет на сайте');
        }
    }


}



