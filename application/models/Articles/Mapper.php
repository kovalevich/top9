<?php 

class Models_Articles_Mapper extends Models_Mapper
{
    
    public function __construct($id = null)
    {
    	parent::__construct('Articles');
    	if ($id) {
    		$this->getRow($id);
    	}
    	return $this;
    }
    
    public function getArticle()
    {
    	return $this->convertRow($this->_row);
    }
    
    public function getNew()
    {
    	$select = $this->_dbTable->select();
    	$select->order('created desc')
            ->where('public = ?', '1')
    	->limit(5);
    
    	$resultSet = $this->_dbTable->fetchAll($select);
    
    	return $this->convertRows($resultSet);
    }

    public function getUnpublic()
    {
        $select = $this->_dbTable->select();
        $select->order('created desc')
            ->where('public = ?', '0');

        $resultSet = $this->_dbTable->fetchAll($select);

        return $this->convertRows($resultSet);
    }
    
    public function getAllArticles($cat_id = null)
    {
    	$select = $this->_dbTable->select();
        $select->where('public = ?', '1');
    	if ($cat_id !== null)
    		$select->where('category_id = ?', $cat_id);
    
    	$resultSet = $this->_dbTable->fetchAll($select);
    
    	return $this->convertRows($resultSet);
    }
    
    public function getSearch ($id = null)
    {
    	$select = $this->_dbTable->select();
    	$select->where('id LIKE ?', $id.'%')
    	->limit(5, 0);
    	$resultSet = $this->_dbTable->fetchAll($select);
    
    	return $this->convertRows($resultSet);
    }
    
    public function getPaginator ($page = 1, $cat = false)
    {
    	$select = $this->_dbTable->select();
        $select->where('public = ?', '1')
            ->order('created desc');
        if($cat) {
            $select->where('category_id = ?', $cat);
        }

    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	$paginator = new Zend_Paginator($adapter);
    	$paginator->setCurrentPageNumber($page);
    	$paginator->setItemCountPerPage ($this->_config->on_page);

    	return $paginator;
    }
    
    
    public function convertRow($row)
    {
    	$entry = parent::convertRow($row);
    	$cat_model = new Models_Categories_Mapper($row->category_id);
    	$entry->category = $cat_model->getCategory();
    
    	return $entry;
    }
    
    public function save()
    {
    	Classes_Cache::clear(array('articles'));
    	parent::save();
    } 
    
    public function delete($id)
    {
        $this->getRow($id);

        $model_categories = new Models_Categories_Mapper($this->category_id);
        if ($model_categories->id) {
            $model_categories->count--;
            $model_categories->save();
        }
    	Classes_Cache::clear(array('articles', 'categories'));
    	parent::delete($id);
    }
}

?>