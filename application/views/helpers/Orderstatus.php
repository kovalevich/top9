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
class Zend_View_Helper_Orderstatus
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function orderstatus ($status)
    {
        switch ($status){
            case '0': return 'в рассмотрении'; break;
            case '1': return 'ожидает предоплаты'; break;
            case '2': return 'в работе'; break;
            case '3': return 'ожидает окончательной оплаты'; break;
            case '4': return 'оплачен'; break;
            case '5': return 'на доработке'; break;
            case '6': return 'закрыт'; break;
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
