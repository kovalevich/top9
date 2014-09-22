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
class Zend_View_Helper_Submit extends Zend_View_Helper_FormSubmit
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function submit ($name, $label, $attribs)
    {
        if (isset($attribs['options'])) {
        	unset($attribs['options']);
        }
        if (isset($attribs['viewScript'])) {
        	unset($attribs['viewScript']);
        }
        $xhtml = '<button id="submit" name="'.$name.'" '. $this->_htmlAttribs($attribs).'><div>'.$label.'</div></button>';

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
