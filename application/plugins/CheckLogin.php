<?php

class Application_Plugin_CheckLogin extends Zend_Controller_Plugin_Abstract
{
    protected $_userModel;
    
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request){
        if (Zend_Auth::getInstance()->hasIdentity()) {
        	$auth = Zend_Auth::getInstance();
        	$user = $auth->getIdentity();
        	$model = $this->_getUserModel($user->id);
        	$auth->getStorage()->write($model->getUser());
        }
    
    }
    
    public function _getUserModel($id){
    	if (null === $this->_userModel) {
    		require_once APPLICATION_PATH . '/models/UserMapper.php';
    		$this->_userModel = new Model_UserMapper($id);
    	}
    	return $this->_userModel;
    }
}

?>