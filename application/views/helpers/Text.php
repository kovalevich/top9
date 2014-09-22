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
class Zend_View_Helper_Text extends Zend_View_Helper_FormText
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function text ($name, $value = false, $attribs)
    {
        return parent::formText($name, $value, $attribs);
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
