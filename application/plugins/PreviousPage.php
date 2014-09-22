<?php
class Application_Plugin_PreviousPage extends Zend_Controller_Plugin_Abstract
{
    private $_acl = null;
    private $_auth = null;
    
    public function __construct(Zend_Auth $auth)
    {
        $this->_auth = $auth;
    }
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $params = $request->getParams();
        $action = $request->getActionName();
        $post = $request->getPost();
        
        $redirectspace = new Zend_Session_Namespace('Redirect');
        
        if (isset($post['params'])) {
        	$redirectspace->params = $post["params"];
        }
        else 
            if (!empty($params))
                $redirectspace->params = $params;
        
        if($controller != 'auth' && $controller != 'error' && $controller != 'getitem' && $controller != 'registration' && $action != 'registration')
        {
        	$redirectspace->module = $module;
        	$redirectspace->controller = $controller;
        	$redirectspace->action = $action;
        }
    }
}
