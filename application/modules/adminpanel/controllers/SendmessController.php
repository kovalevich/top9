<?php

class Adminpanel_SendmessController extends Zend_Controller_Action
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
    
    public function preDispatch()
    {
    	$this->_helper->layout()->disableLayout();
    }

    public function indexAction()
    {
        $model = new Models_Users_Mapper();
        $type = $this->_request->getParam('type', 'user');
        $users = $type == 'user' ? $model->getUsers() : $model->getAuthors();
        $mail = new Classes_MailManager();
        $subject = $this->_request->getParam('subject');
        $text = $this->_request->getParam('text');
        //var_dump($authors);
        foreach ($users as $user) {
            $mail->mailto($user, $subject, $text);
        }
    }


}

