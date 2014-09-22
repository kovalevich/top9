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
class Zend_View_Helper_Mailto
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function mailto ($email = null)
    {
        $xhtml = "<a href=\"mailto:{$email}\" title=\"Написать письмо\">{$email}</a>";
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
