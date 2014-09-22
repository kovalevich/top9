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
class Zend_View_Helper_ThemesTable
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;
    
    private $class;

    /**
     */
    public function themestable ($entries)
    {
        $body = '';
        if (!$body = Classes_Cache::get('catalog_tree')) {
            if (count($entries) > 0) {
                foreach ($entries as $key=>$entry) {
                	$body .= '<div class="subject"><h3>' . $key . '</h3>
                              <div>';
                	foreach ($entry as $item) {
                	    $body .= '<a href="' . $this->view->url(array('id' => $item->id),'catalogTheme') . '">' . $this->view->escape($item->title) . ' (' . count($item->getProjects()) . ') </a>';
                	}
                	$body .= '</div></div>';
                }
            } 
        	Classes_Cache::save($body, 'catalog_tree', array('themes', 'categories', 'projects'));
        }
   
        return $body;
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
    
    private function toogleClass ()
    {
        if ($this->class == 'even') {
        	$this->class = 'odd';
        }
        else $this->class = 'even';
        
        return $this->class;
    }
}
