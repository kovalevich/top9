<?php 

class Models_Sites_Model extends Models_Model
{
    
    public $id, $title, $created, $description, $category;
    
    public function __construct(array $options = null)
    {
        parent::__construct($options);
    }
}

?>