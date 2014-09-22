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
class Zend_View_Helper_Purchasestatus
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function purchasestatus ($status)
    {
        switch ($status){
            case '0': return 'Ожидает оплаты'; break;
            case '1': return 'Оплачена'; break;
        }
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
