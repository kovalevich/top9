<?php

class Adminpanel_CategoriesController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        $model = new Models_Categories_Mapper();
        $this->view->categories = $model->getAll();
    }

    public function addAction()
    {
        $form = new Application_Form_Category();
        
        if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
        	$model = new Models_Categories_Mapper();
        	$model->getRow();
        	$model->fill($form->getValues());
        	$model->save();
        	$this->_helper->redirector('index', 'categories', 'adminpanel');
        }
        $this->view->form = $form;
    }

    public function deleteAction()
    {
        if ($this->_request->getParam('id', FALSE)) {
        	$model = new Models_Categories_Mapper();
        	$model->delete($this->_request->getParam('id', false));
        	$this->_helper->redirector('index', 'categories', 'adminpanel');
        }
    }

    public function editAction()
    {
        $form = new Application_Form_Category();

        $model = new Models_Categories_Mapper($this->_request->getParam('id', false));
        $form->removeElement('id');
        $form->addElement(new Zend_Form_Element_Hidden('id'), 'id', array(
            'value'=>$this->_request->getParam('id', false)
        ));
        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())){
                $model->fill($form->getValues());
                $model->save();
                $this->_helper->redirector('index', 'categories', 'adminpanel');
            }
        }

        $form->populate($model->getArray());
        $this->view->form = $form;
    }

}