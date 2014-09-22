<?php
/**
 *
 * @author kovalevich
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Nicetime helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Accountsstat
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;
    
    private $class;

    /**
     */
    public function accountsstat ($user_id)
    {
        $list = '';
        
        $model_accounts = new Models_Accounts_Mapper();
        $entries = $model_accounts->getUsersAccount($user_id);
        
        $outed = 0;
        $mostout = 0;
        $order = 0;
        $current = 0;
        
        foreach ($entries as $entry) {
            switch ($entry->status) {
            	case 0: 
            	    $mostout += $entry->ballance;
            	    break;
            	case 1: 
            	    $order += $entry->ballance;
            	    break;
        	    case 2:
        	    	$outed += $entry->ballance;
        	    	break;
        	    case 3:
        	    	$outed += $entry->ballance;
        	    	break;
        	    default: break;
            }
        }
        
        if (count($entries)) {
            $list .=
            '<table><tbody>' .
            '<tr><td>Обналичено</td><td>' . $this->view->currency($outed) . '</td></tr>' .
            '<tr><td>Остаток</td><td>' . $this->view->currency($mostout) . '</td></tr>' .
            '<tr><td>На обналичке</td><td>' . $this->view->currency($order) . '</td></tr>' .
            '</tbody></table>';
        }
        else $list .= 'У вас еще не было счетов';

        return $list;
    }

    /**
     * Sets the view field
     * 
     * @param $view Zend_View_Interface            
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
    
    private function toogleClass ()
    {
        if ($this->class == 'even') {
        	$this->class = 'odd';
        }
        else $this->class = 'even';
        
        return $this->class;
    }
}
