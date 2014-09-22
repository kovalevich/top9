<?php
/**
 *
 * @author kovalevich
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Formselect helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_User
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function user ($user = null)
    {
        if (isset($user->id)) {
        	$xhtml = "<a href=\"{$this->view->url(array('id'=>$user->id), 'edituser')}\">{$user->name}</a>"
                . " <!--<span class=\"information\"> (#{$user->id})</span>-->";
        }
        else $xhtml = '-';
        return $xhtml;
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
}
