<?php 

class Models_Categories_Model extends Models_Model
{
    
    public $id, $title, $description, $count, $sites_count;
    
    public function __construct(array $options = NULL)
    {
        parent::__construct($options);
    }
    
    public function getCategoriesWay()
    {
        $breadcrumbs = ' / '. $this->title;
        $category = $this->parent;
        if ($category)
            while ($category->title != null) {
            	$breadcrumbs = ' / <a href="/categories/' . $category->id . '">' . $category->title . '</a>' . $breadcrumbs;
            	$category = $category->parent;
            }
        
        $breadcrumbs = '<a href="/">Главная</a>' . $breadcrumbs;
        
        return $breadcrumbs;
    }
}

?>