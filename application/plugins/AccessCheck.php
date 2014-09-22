<?php
class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract
{
    private $_acl = null;
    private $_auth = null;
    
    /*
     * Инициализируем данные
     */
    public function __construct(Zend_Acl $acl, Zend_Auth $auth)
    {
        $this->_acl = $acl;
        $this->_auth = $auth;
    }
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        
        // получаем имя текущего ресурса
        $controller =  $request->getControllerName();
        $module  =  $request->getModuleName();
        
        // получаем имя action
        $action = $request->getActionName();
        
        if ($action == 'add' && $module == 'default') {
        	$resource = "{$module}-{$controller}-{$action}";
        }
        else
        	$resource = "{$module}-{$controller}";
        
        // получаем доступ к хранилищу данных Zend,
        // и достаём роль пользователя
        $identity = $this->_auth->getStorage()->read();
        Zend_Registry::set('user', $identity);
        // если в хранилище ничего нет, то значит мы имеем дело с гостем
        $role = !empty($identity->role) ? $identity->role : 'guest';
        
        if (!$this->_acl->has($resource))
        	return true;
        
        // если пользователь не допущен до данного ресурса,
        // то отсылаем его на страницу авторизации
        if (!$this->_acl->isAllowed($role, $resource, $action)) {
        	if ($role != 'guest')
        		$request->setModuleName('default')->setControllerName('auth')->setActionName('noaccess');
        	else {
        		$request->setModuleName('default')->setControllerName('auth')->setActionName('login');
        	}
        }
    }
}
