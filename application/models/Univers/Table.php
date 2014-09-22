<?php
class Models_Univers_Table extends Models_Table
{
    
    public function __construct()
    {
    	parent::__construct('univers');
    }
    
    protected $_referenceMap    = array(
        'city' => array(
            'columns'           => 'city_id',
            'refTableClass'     => 'Models_Cities_Table',
            'refColumns'        => 'id'
        ),
    );

    public function getName()
    {
        return $this->_name;
    }
    
}