<?php

class Adminpanel_CollegesController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        $model = new Models_Colleges_Mapper();
        $this->view->page = $model->getPage($this->_request->getParam('page',1));
        $this->view->colleges = $model->convertRows($this->view->page);
    }

    public function addAction()
    {

    }

    public function editAction()
    {
        $form = new Application_Form_Univer();
        $form->removeElement('id');
        $form->addElement(new Zend_Form_Element_Hidden('id'), 'id', array(
            'value'=>$this->_request->getParam('id', FALSE)
        ));
        $model = new Models_Colleges_Mapper($this->_request->getParam('id', FALSE));

        if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {

            $model->fill($form->getValues());
            $model->save();
            $this->_helper->redirector('index', 'colleges', 'adminpanel');
        }

        $form->populate($model->getArray());
        $this->view->form = $form;
    }

    public function deleteAction()
    {

    }

}