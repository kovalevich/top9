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
class Zend_View_Helper_Select extends Zend_View_Helper_FormSelect
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function select ($name, $options = false, $attribs, $value = false)
    {
        $value = $value ? $value : '';
        $xhtml = '<ul class="drop">';
	    foreach ($options as $key=>$option){
		    $xhtml .= '<li id="'.$key.'">'.$option.'</li>';
		}
	    $xhtml .= '</ul>';
	    if (isset($attribs['options'])) {
	    	unset($attribs['options']);
	    }
	    if (isset($attribs['viewScript'])) {
	    	unset($attribs['viewScript']);
	    }
	    $xhtml .= '<input type="hidden" id="'.$name.'"  name="'.$name.'" value="'.$value.'"' 
	            . $this->_htmlAttribs($attribs).'/>';
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
