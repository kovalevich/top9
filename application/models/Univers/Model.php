<?php 

class Models_Univers_Model extends Models_Model
{

    public $id, $name, $full_name, $description, $votes, $place, $concurents, $city, $desire, $rating, $hits, $type = 'univer';

    public function __construct (array $options = NULL)
    {
        parent::__construct($options);
    }
    
}

?>