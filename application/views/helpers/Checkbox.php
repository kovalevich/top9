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
class Zend_View_Helper_Checkbox extends Zend_View_Helper_FormCheckbox
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function checkbox ($name, $value = null, $attribs = null, array $checkedOptions = null)
    {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, id, value, attribs, options, listsep, disable
        $active = '';
        $checked = false;
        if (isset($attribs['checked']) && $attribs['checked']) {
            $checked = true;
            $active = ' active';
            unset($attribs['checked']);
        } elseif (isset($attribs['checked'])) {
            $checked = false;
            unset($attribs['checked']);
        }
        
        if (isset($attribs['text'])) {
        	$text = $attribs['text'];
        }

        $checkedOptions = self::determineCheckboxInfo($value, $checked, $checkedOptions);

        $disable = false;
        if (isset($attribs['disable']) && $attribs['disable']) {
        	$disable = true;
        	$disabled = ' disabled="disabled"';
        	unset($attribs['disable']);
        } elseif (isset($attribs['disable'])) {
        	$disable = false;
        	unset($attribs['disable']);
        }
        // is the element disabled?
        $disabled = '';
        if ($disable) {
            $disabled = ' disabled="disabled"';
        }

        // build the element
        $xhtml = '';

        if (array_key_exists('disableHidden', $attribs)) {
            unset($attribs['disableHidden']);
        }

        $xhtml .= '<div class="check'.$active.'" '
                . $this->_htmlAttribs($attribs)
                . '>'
                . $this->view->escape($text) . '<input type="checkbox"'
                . ' name="' . $this->view->escape($name) . '"'
                . ' value="' . $this->view->escape($checkedOptions['checkedValue']) . '"'
                . $checkedOptions['checkedString']
                . $disabled
                . $this->_htmlAttribs($attribs)
                . $this->getClosingBracket()
                . '</div>';

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
