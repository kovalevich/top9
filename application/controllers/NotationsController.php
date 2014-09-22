<?php

class NotationsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
    
    public function preDispatch()
    {
    	$this->_helper->layout()->disableLayout();
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        if ($this->_request->isPost()) {
        	$model = new Model_NotationMapper();
        	$model->fill($this->_request->getPost());
        	$model->created = date('Y-m-d H:i:s');
        	$model->save();
        	$this->view->message = $this->view->translate('notice saved');
        }
        else {
            $this->view->message = $this->view->translate('error');
        }
    }

    public function getAction()
    {
    	$model = new Model_NotationMapper();
        $order = $this->_request->getParam('order', false);
    	$this->view->items = $model->getLast($order);
    }


}





