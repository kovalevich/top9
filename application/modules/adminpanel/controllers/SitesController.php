<?php

class Adminpanel_SitesController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('controls_articles.phtml');

        if(!$categories = Classes_Cache::get('categories')){
            $model_categories = new Models_Categories_Mapper();
            $categories = $model_categories->getAll();
            Classes_Cache::save($categories, 'categories', array('categories', 'articles'));
        }
        $this->view->categories = $categories;

        $model = new Models_Sites_Mapper();
        $category = $this->_request->getParam('category_id', false);
        Zend_Registry::set('category', $category);

        $paginator = $model->getPaginator($this->getParam('page', 1), $category);
        $this->view->entries = $model->convertRows($paginator);
        $this->view->paginator = $paginator;
    }

    public function addAction()
    {
        if(!$categories = Classes_Cache::get('categories')){
            $model_categories = new Models_Categories_Mapper();
            $categories = $model_categories->getAll();
            Classes_Cache::save($categories, 'categories', array('categories', 'articles'));
        }
        $this->view->categories = $categories;

        $form = new Application_Form_Site();
        $model = new Models_Sites_Mapper();
        if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
            $model->getRow();
            $model->fill($form->getValues());
            $model->created = date('Y-m-d H:i:s');
            $model->save();

            $model_categories = new Models_Categories_Mapper($model->category_id);
            if ($model_categories->id) {
                $model_categories->sites_count++;
                $model_categories->save();
            }

            $this->_helper->redirector('index', 'sites', 'adminpanel');
        }
        $this->view->form = $form;
    }

    public function editAction()
    {
        if(!$categories = Classes_Cache::get('categories')){
            $model_categories = new Models_Categories_Mapper();
            $categories = $model_categories->getAll();
            Classes_Cache::save($categories, 'categories', array('categories', 'articles'));
        }
        $this->view->categories = $categories;

        $form = new Application_Form_Site();
        $form->removeElement('id');
        $form->addElement(new Zend_Form_Element_Hidden('id'), 'id', array(
            'value'=>$this->_request->getParam('id', FALSE)
        ));
        $model = new Models_Sites_Mapper($this->_request->getParam('id', FALSE));

        if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {

            $model->fill($form->getValues());
            $model->save();
            $this->_helper->redirector('index', 'sites', 'adminpanel');
        }

        $form->populate($model->getArray());
        $this->view->form = $form;
    }

    public function deleteAction()
    {
        if ($this->_request->getParam('id', FALSE)) {
            $model = new Models_Sites_Mapper();
            $model->delete($this->_request->getParam('id', FALSE));
            $this->_helper->redirector('index', 'sites', 'adminpanel');
        }
    }

}