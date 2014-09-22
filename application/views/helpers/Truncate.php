<?php
/**
 *
 * @author kovalevich
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Truncate helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Truncate
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function truncate($string, $length = 80, $etc = '...', $break_words = false, $middle = false)
    {
    	if ($length == 0)
            return '';
            
        if (strlen($string) > $length) {
            $length -= min($length, strlen($etc));
            if (! $break_words && ! $middle) {
                $string = preg_replace('/\s+?(\S+)?$/', '', mb_substr($string, 0, $length + 1));
            }
            if (! $middle) {
                return mb_substr($string, 0, $length) . $etc;
            } else {
                return mb_substr($string, 0, $length / 2) . $etc . mb_substr($string, -$length / 2);
            }
        } else {
            return $string;
        };
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
