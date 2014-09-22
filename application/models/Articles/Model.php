<?php 

class Models_Articles_Model extends Models_Model
{
    
    public $id, $title, $text, $modified, $created, $views, $meta_title, $meta_keywords, $meta_description, $category;
    
    public function __construct(array $options = null)
    {
        parent::__construct($options);
    }
}

?>