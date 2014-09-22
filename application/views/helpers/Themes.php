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
class Zend_View_Helper_Themes extends Zend_View_Helper_FormElement
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function themes ($type = null, $checked = null)
    {
        $xhtml = '';
        $checked_cat = null;
        if ($checked) {
        	$model_theme = new Models_Themes_Mapper($checked);
        	$checked_cat = $model_theme->category;
        }
        
        if ($type == 'categoriesbutton') {
            if (!$categories = Classes_Cache::get('themescategories')) {
            	$model_cat = new Models_Themescategories_Mapper();
                $categories = $model_cat->getAll();
            	Classes_Cache::save($categories, 'themescategories', array('themescategories'));
            }
            
            foreach ($categories as $category) {
                $xhtml .= '<a id="' . $category->id . '" ' . ($checked_cat == $category->id ? 'class="checked"' : '') . '>' . $category->title . '</a>';
            }
        }
        if ($type == 'tree') {
            
            if (!$themes = Classes_Cache::get('themestreeid')) {
            	$model_themes = new Models_Themes_Mapper();
                $themes = $model_themes->getTree('id');
            	Classes_Cache::save($themes, 'themestreeid', array('themes', 'categories'));
            }

            foreach ($themes as $k=>$category) {
                $xhtml .= '<div id="' . $k . '" ' . ($checked_cat != $k ? 'class="hide" ' : '') . '>';
                foreach ($category as $theme) {
                    $xhtml .= '<a id="' . $theme->id . '" ' . ($checked == $theme->id ? 'class="checked"' : '') . '>' . $theme->title . '</a>';
                }
                $xhtml .= '</div>';
            }
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
