<?php 

class Models_Categories_Mapper extends Models_Mapper
{
    
    public function __construct($id = null)
    {
    	parent::__construct('Categories');
    	if ($id) {
    		$this->getRow($id);
    	}
    	return $this;
    }
    
    public function getCategory()
    {
        return $this->convertRow($this->_row);
    }
    
    public function getAll($parent_id = false)
    {
        $select = $this->_dbTable->select();

        if($parent_id !== false) {
            $select->where('parent_id = ?', $parent_id);
        }
        $res = $this->_dbTable->fetchAll($select);
        return $this->convertRows($res);
    }
    
    public function getParent($row)
    {
        if (isset($row->parent_id)) {
            return $this->convertRow($this->_dbTable->find($row->parent_id));
        }    
        else {
            return null;
        }
    }
    
    public function convertRow($row)
    {
        $entry = parent::convertRow($row);
        $entry->parent = $this->getParent($row);
        return $entry;
    }
    
    public function save()
    {
    	Classes_Cache::clear(array('categories'));
    	parent::save();
    }
    
    public function delete($id)
    {
    	Classes_Cache::clear(array('categories'));
    	parent::delete($id);
    }
    
}

?>