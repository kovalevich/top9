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
class Zend_View_Helper_Projectsfiles
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;
    
    private $class;

    /**
     */
    public function projectsfiles ($entries, $type = 'full')
    {
        $files = '';
        
        if (is_array($entries)) {
        	if (count($entries) > 0) {
        	    foreach ($entries as $entry)
        		    $files .= $this->convert($entry, $type);
        	};
        }
        else
            $files = $this->convert($entries, $type);
        
        return $files;
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
    
    private function convert($entry, $type)
    {
        if ($entry instanceof Models_Files_Model) {
        	if ($type == 'full') {
        	    return "<p><a href=\"{$entry->getLinc()}\">{$entry->name}</a></p>";
        	}
        	elseif ($type == 'small') {
        	    return "<p>{$entry->getName()}</p>";
        	}
        	else return '';
        }
        else return '';
    }
}
