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
class Zend_View_Helper_Multicheckbox extends Zend_View_Helper_FormMultiCheckbox
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function multicheckbox ($name, $options = null, $value = null)
    {
        $xhtml = '';
        // ensure value is an array to allow matching multiple times
        $value = (array) $value;
	    foreach ($options as $key=>$option){
	        // is it checked?
	        $checked = '';
	        $active = '';
	        if (in_array($key, $value)) {
	        	$checked = ' checked="checked"';
	        	$active = ' active';
	        }
	        $xhtml .= '<div class="check'.$active.'">
				'.$option.'
				<input type="checkbox" name="'.$name.'[]" value="'.$key.'" '.$checked.'/>
			</div>';
		}
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
