<?php

class AuthController extends Zend_Controller_Action
{

    protected $_config = null;

    public function init()
    {
        $this->_config = Zend_Registry::get('_config')->my;
    }

    public function indexAction()
    {
        $this->_helper->redirector('login');
    }

    public function loginAction()
    {
        $user = Zend_Registry::get('user');
        if ($user) {
            $this->_helper->redirector('index', 'index');
        }
    
    	// создаём форму и передаём её во view
    	$form = new Application_Form_Login();
    	$this->view->form = $form;

    	// Если к нам идёт Post запрос
    	if ($this->getRequest()->isPost()) {
    		// Принимаем его
    		$formData = $this->getRequest()->getPost();
    
    		// Если форма заполнена верно
    		if ($form->isValid($formData)) {
    			// Получаем адаптер подключения к базе данных
    			$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
    
    			// указываем таблицу, где необходимо искать данные о пользователях
    			// колонку, где искать имена пользователей,
    			// а также колонку, где хранятся пароли
    			$authAdapter->setTableName('users')
    			->setIdentityColumn('email')
    			->setCredentialColumn('password');
    
    			// получаем введённые данные
    			$username = $this->getRequest()->getPost('email');
    			$password = md5(md5($this->getRequest()->getPost('password')).md5($this->_config->salt));
    
    			// подставляем полученные данные из формы
    			$authAdapter->setIdentity($username)
    			->setCredential($password);
    
    			// получаем экземпляр Zend_Auth
    			$auth = Zend_Auth::getInstance();
    
    			// делаем попытку авторизировать пользователя
    			$result = $auth->authenticate($authAdapter);
    
    			// если авторизация прошла успешно
    			if ($result->isValid()) {
    				// используем адаптер для извлечения оставшихся данных о пользователе
    				$identity = $authAdapter->getResultRowObject();

                    if ($identity->status < 2) {
                        // получаем доступ к хранилищу данных Zend
                        $authStorage = $auth->getStorage();

                        // помещаем туда информацию о пользователе,
                        // чтобы иметь к ним доступ при конфигурировании Acl
                        $authStorage->write($identity);

                        /*$model = new Model_UserMapper($identity->id);
                        $model->last_visit = date('Y-m-d H:i:s');
                        $model->save();*/
                        $this->_helper->redirector('index', 'index', 'adminpanel');
                    }
                    else {
                        $this->view->errMessage = 'Этот аккаунт заблокирован, или удален!';
                    }
    		    } else {
    				$this->view->errMessage = 'Вы ввели неверное имя пользователя или неверный пароль';
    			}
    		}
    	}
    }

    public function logoutAction()
    {
        // уничтожаем информацию об авторизации пользователя
        Zend_Auth::getInstance()->clearIdentity();
        // и отправляем его на главную
        $this->_helper->redirector('login', 'auth');
    }

    public function noaccessAction()
    {
        // action body
    }


}







