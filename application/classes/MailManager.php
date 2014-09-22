<?php

class Classes_MailManager
{
    protected $_zMail;
    public $template;
    
    protected function _getMail(){
    	$this->_zMail = new Zend_Mail('UTF-8');
    	return $this->_zMail;
    }
    
    public function __construct()
    {
        $this->template = new Zend_View(array('basePath'=>APPLICATION_PATH.'/views'));
    }
    
    public function sentTemplateMail ($email, $subject, $template, $data) 
    {
        try{
            $this->template->data = $data;
            $body = $this->template->render('/mail/' . $template . '.phtml');
            $mail = $this->_getMail();
            $mail->setBodyText($body)
            ->setFrom('donotreply@diplomov.by', 'diplomov.by')
            ->addTo($email, $email)
            ->setSubject($subject)
            ->send();
        }catch (Zend_Mail_Exception $e){
			//����� ������ � ����
		}catch (Zend_Mail_Transport_Exception $e){
			//����� ������ � ����
		}
        
    }
    
    public function sendPasswordEmail($user, $pass){
    	if(trim($user->email)){
    		try{
    			$emailConfirmTemplate = new Zend_View(array('basePath'=>APPLICATION_PATH.'/views'));
    			$emailConfirmTemplate->user = $user;
    			$emailConfirmTemplate->password = $pass;
    			$body = $emailConfirmTemplate->render("/mail/sendPass.phtml");
    			$mail = $this->_getMail();
        	    $mail->setBodyText($body)
    			->setFrom('donotreply@diplomov.by', 'diplomov.by')
    			->addTo($user->email, $user->email)
    			->setSubject($emailConfirmTemplate->translate('mailsubject'))
    			->send();
    
    		}catch (Zend_Mail_Exception $e){
    			//����� ������ � ����
    		}catch (Zend_Mail_Transport_Exception $e){
    			//����� ������ � ����
    		}
    	}
    }
    
    public function sendOrderEmail($order){
        
        $emailConfirmTemplate = new Zend_View(array('basePath'=>APPLICATION_PATH.'/views'));        
        $emailConfirmTemplate->order = $order;
        
        $model_cat = new Models_Themescategories_Mapper($order->theme->category->id);
        $authors = $model_cat->getAuthors();

        if (count($authors)) {
        	foreach ($authors as $user) {
        	    if(trim($user->email)){
        	    	try{
        	    	    $emailConfirmTemplate->user = $user;
        	    	    $emailConfirmTemplate->theme = $order->theme;
        	    	    $body = $emailConfirmTemplate->render("/mail/sendOrder.phtml");
        	    	    $mail = $this->_getMail();
        	    	    $mail->setBodyText($body)
        	    		->setFrom('donotreply@diplomov.by', 'diplomov.by')
        	    		->addTo($user->email, $user->email)
        	    		->setSubject($emailConfirmTemplate->translate('mailsubjectorder'))
        	    		->send();
        	    
        	    	}catch (Zend_Mail_Exception $e){
        	    		//����� ������ � ����
        	    	}catch (Zend_Mail_Transport_Exception $e){
        	    		//����� ������ � ����
        	    	}
        	    }
        	}
        }
        
    }
    
    public function mailto ($user, $subject, $text) {
        if(trim($user->email)){
        	try{
        		$mail = $this->_getMail();
        		$mail->setBodyText($text)
        		->setFrom('donotreply@diplomov.by', 'diplomov.by')
        		->addTo($user->email, $user->email)
        		->setSubject($subject)
        		->send();
        		 
        	}catch (Zend_Mail_Exception $e){
        		//����� ������ � ����
        	}catch (Zend_Mail_Transport_Exception $e){
        		//����� ������ � ����
        	}
        }
    }
}

?>