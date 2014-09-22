<?php 

class Models_Cities_Model extends Models_Model
{

    public $id, $name, $description, $votes, $desire, $rating, $hits, $place, $concurents, $type = 'city';

    public function __construct (array $options = NULL)
    {
        parent::__construct($options);
    }
    
}

?>