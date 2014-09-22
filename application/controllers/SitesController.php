<?php

class SitesController extends Zend_Controller_Action
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
            Classes_Cache::save($categories, 'categories', array('categories', 'sites'));
        }
        $this->view->categories = $categories;

        if(!$sites = Classes_Cache::get('newsites')){
            $model_sites = new Models_Sites_Mapper();
            $sites = $model_sites->getNew();
            Classes_Cache::save($sites, 'newsites', array('sites'));
        }
        $this->view->sites = $sites;
    }

    public function addAction()
    {
        $form = new Application_Form_Site();
        $model = new Models_Sites_Mapper();

        if(!$categories = Classes_Cache::get('categories')){
            $model_categories = new Models_Categories_Mapper();
            $categories = $model_categories->getAll();
            Classes_Cache::save($categories, 'categories', array('categories', 'sites'));
        }
        $this->view->categories = $categories;

        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $model->getRow();
                $model->fill($form->getValues());
                $model->created = date('Y-m-d H:i:s');
                $model->public = 0;
                $model->save();

                $model_categories = new Models_Categories_Mapper($model->category_id);
                if ($model_categories->id) {
                    $model_categories->sites_count++;
                    $model_categories->save();
                }
                $this->view->message = '<strong>Поздравляем!</strong> Ваш сайт успешно добавлен в каталог top9.by и станет доступен после проверки модератором!';
            }
            else {
                $this->view->errors = '<strong>Ошибка!</strong> Все поля формы должны быть заполненны!';
            }
        }
        $this->view->form = $form;
    }

    public function siteAction()
    {
        if (true && $id = $this->_request->getParam('id', false)) {
            $cache_id = preg_replace('[-]', '_', $id);
            $cache_id = preg_replace('[\.]', '', $cache_id);
            if (!$site = Classes_Cache::get('site' . $cache_id)) {
                $model = new Models_Sites_Mapper($id);
                $site = $model->getSite();
                Classes_Cache::save($site, 'site'.$cache_id, array('sites'));
            }
            if ($site->id){
                $this->view->site = $site;
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
                Classes_Cache::save($category, 'category'.$id, array('categories'));
            }
            if ($category->id) {
                $page = $this->_request->getParam('page', 1);
                if (!$sites = Classes_Cache::get('sitesfromcat' . $category->id . 'page' . $page)) {
                    $model = new Models_Sites_Mapper();
                    $paginator = $model->getPaginator($page, $category->id);
                    $sites = $model->convertRows($paginator);
                    Classes_Cache::save($sites, 'sitesfromcat' . $category->id . 'page' . $page, array('sites'));
                    Classes_Cache::save($paginator->__toString(), 'paginatorsitesfromcat' . $category->id . 'page' . $page, array('sites'));
                }

                $this->view->paginator = Classes_Cache::get('paginatorsitessfromcat' . $category->id . 'page' . $page);
                $this->view->sites = $sites;
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