<?php 

class Models_Colleges_Model extends Models_Model
{

    public $id, $name, $full_name, $description, $votes, $desire, $rating, $hits, $place, $concurents, $city, $type = 'college';

    public function __construct (array $options = NULL)
    {
        parent::__construct($options);
    }
    
}

?>