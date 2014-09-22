<?php

class Adminpanel_UsersController extends Zend_Controller_Action
{
    protected $config;
    
    public function init()
    {
        $container = new Zend_Navigation(Zend_Registry::get('config')->resources->navigation->adminpages);
        $this->view->container = $container;
        $this->user = Zend_Registry::get('user');
        $this->view->user = $this->user;
        $this->config = Zend_Registry::get('config')->my;
    }

    public function indexAction()
    {
        
        $this->view->title = $this->view->translate('users control');
        $this->view->headTitle($this->view->title, 'PREPEND');

        Zend_View_Helper_PaginationControl::setDefaultViewPartial('controls1.phtml');
        
        $role = $this->_request->getParam('role', 'user');
        Zend_Registry::set('role', $role);
        $model = new Models_Users_Mapper();
    
    	$paginator = $model->getPaginator($this->getParam('page', 1));
    	
    	$this->view->entries = $model->convertRows($paginator);
    	$this->view->paginator = $paginator;
        $this->view->role = $role;
    }

    public function deleteAction()
    {
        if ($this->_request->getParam('id', FALSE)) {
        	$model = new Models_Users_Mapper($this->_request->getParam('id', FALSE));
        	$model->delete($this->_request->getParam('id', FALSE));
        	$this->_helper->redirector('index', 'users', 'adminpanel');
        }

    }

    public function editAction()
    {
        $this->view->title = $this->view->translate('editpage');
        $this->view->headTitle($this->view->title, 'PREPEND');
        $form = new Application_Form_Edituser();
        $model = new Models_Users_Mapper($this->_request->getParam('id'));
        $form->populate($model->getArray());
        $this->view->entry = $model->getUser();
        $this->view->entry->files = $model->getFiles();
        
        $model_projects = new Models_Projects_Mapper();
        $this->view->projects = $model_projects->getUserProjects($model->id);
        
        $model_orders = new Models_Orders_Mapper();
        $this->view->orders = $model_orders->getAuthorsOrders($model->id);
        
        $this->view->user_themes = $model->getThemes();
        
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
        	if ($form->isValid($this->getRequest()->getPost())) {
        	    $model->fill($form->getValues());
                if ($model->status == 3) {
                    $model->email .= 'block';
                }
        	    $model->modified = date('Y-m-d H:i:s');
        	    $model->save();
        	    $this->_helper->redirector('index', 'users', 'adminpanel');
        	}
        }
    }

    public function reportAction()
    {
        $this->view->title = 'Отчет';
        $this->view->headTitle($this->view->title, 'PREPEND');
        
        $form = new Application_Form_Interval();

        $model = new Models_Users_Mapper($this->_request->getParam('id'));
        $this->view->user = $model->getUser();
        
        $model_orders = new Models_Orders_Mapper();
        $first = $this->_request->getParam('first', false);
        $last = $this->_request->getParam('last', false);
        $this->view->orders = $model_orders->getAuthorsOrders($model->id, $first, $last);
        
        if ($this->_request->isPost()) {
        	$form->populate($this->_request->getParams());
        }
        $this->view->form = $form;
    }

    public function edipasswordAction()
    {
        $this->view->title = 'Изменить пароль';
        $this->view->headTitle($this->view->title, 'PREPEND');
        $form = new Application_Form_EditPassword();

        $model = new Models_Users_Mapper($this->_request->getParam('id'));
        $form->setAction('/adminpanel/users/editpassword/' . $model->id);
        if ($this->getRequest()->isPost()) {
        	if ($form->isValid($this->getRequest()->getPost())) {
                $password = $this->_request->getParam('password');
                $model->password = md5(md5($password).md5($this->config->salt));
        		$model->modified = date('Y-m-d H:i:s');
        		$model->save();
        		$this->_helper->redirector('index', 'users', 'adminpanel');
        	}
        	else $this->view->form = $form;
        }
        else $this->view->form = $form;
    }


}