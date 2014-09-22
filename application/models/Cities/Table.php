<?php
class Models_Cities_Table extends Models_Table
{
    
    public function __construct()
    {
    	parent::__construct('cities');
    }

    public function getName()
    {
        return $this->_name;
    }
    
}