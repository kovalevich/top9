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
class Zend_View_Helper_Edit
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function edit ($type, $obj)
    {
        $url = '';

        switch ($type) {
            case 'category': {
                $url = $this->view->url(array('id'=>$obj->id), 'editcategory');
                break;
            }
            case 'article': {
                $url = $this->view->url(array('id'=>$obj->id), 'editarticle');
                break;
            }
            case 'site': {
                $url = $this->view->url(array('id'=>$obj->id), 'editsite');
                break;
            }
            case 'univer': {
                $url = $this->view->url(array('id'=>$obj->id), 'edituniver');
                break;
            }
            case 'college': {
                $url = $this->view->url(array('id'=>$obj->id), 'editcollege');
                break;
            }
            case 'city': {
                $url = $this->view->url(array('id'=>$obj->id), 'editcity');
                break;
            }
        }

        $html = '<a href="' . $url . '"><span class="glyphicon glyphicon-pencil"></span></a>';

        return $html;
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
