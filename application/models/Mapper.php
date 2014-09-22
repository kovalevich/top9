<?php

class Models_Mapper
{
    protected $_dbTable;
    protected $_row;
    protected $_config;
    protected $_name;
    protected $_db;
    
    public function __construct($name = null)
    {
        $this->_name = $name;
     	$this->_config = Zend_Registry::get('_config')->my;
    	
    	$className = 'Models_' . $this->_name . '_Table';
    	$this->_dbTable = new $className();
        $this->_db = $this->_dbTable->getDefaultAdapter();
    }
    
    public function getNullRow()
    {
    	return $this->_dbTable->createRow();
    }
    
    public function getRow($id = NULL)
    {
        if ($id) {
        	$this->_row = $this->_dbTable->find($id)->current();
        }
        if (!$this->_row) 
            $this->_row = $this->_dbTable->createRow();
        return $this->_row;
    }
    
    public function save()
    {
    	return $this->_row->save();
    }

    public function update($name, $data, $where)
    {
        return $this->_db->update($name, $data, $where);
    }
    
    public function fill(array $options)
    {
        if (count($options))
        	foreach ($options as $key=>$option){
        		if (isset($this->_row->$key)) {
        			$this->_row->$key = $option;
        		}
        	}
    }
    
    public function getArray ()
    {
    	return $this->_row->toArray();
    }
    
    public function convertRows($data)
    {
    	$entries   = array();
    	if (count($data))
        	foreach ($data as $row){
        		$entries[] = $this->convertRow($row);
        	}
    	return $entries;
    }

    public function convertRowsFull($data)
    {
        $entries   = array();
        if (count($data))
            foreach ($data as $row){
                $entries[] = $this->convertRowFull($row);
            }
        return $entries;
    }
    
    public function trash()
    {
        $this->_row->visible = 0;
        $this->save();
    }
    
    public function delete($id)
    {
    	$this->_dbTable->delete($this->_dbTable->getAdapter()->quoteInto('id = ?', $id));
    }
    
    public function __set($name, $val)
    {
        $method = 'set'.ucfirst($name);
    	if (!method_exists($this, $method)) {
    		if (isset($this->_row->$name)) {
    			$this->_row->$name = $val;
    		}
    	}
    	else {
    		$this->$method($val);
    	}
    }
    
    public function __get($name)
    {
    	return isset($this->_row->$name) ? $this->_row->$name : null;
    }
    
    public function convertRow($row)
    {
        $className = 'Models_' . $this->_name . '_Model';
        if (!($row instanceof Zend_Db_Table_Row_Abstract)) {
            $row = $this->getNullRow();
        }
        return new $className($row->toArray());
    }

    public function convertRowFull($row)
    {
        $className = 'Models_' . $this->_name . '_Model';
        if (!$row) {
            $row = array();
        }
        return new $className($row);
    }
}

?>