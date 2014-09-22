<?php 

class Models_Users_Mapper extends Models_Mapper
{
    
    public function __construct($id = null)
    {
    	parent::__construct('Users');
    	if ($id) {
    		$this->getRow($id);
    	}
    	return $this;
    }
    
    public function getUser()
    {
    	return $this->convertRow($this->_row);
    }
    
    public function getAllUsers()
    {
    	$resultSet = $this->_dbTable->fetchAll();
    	return $this->convertRows($resultSet);
    }
    
    public function getNewAuthors()
    {
    	$select = $this->_dbTable->select();
    	$select->where('role = ?', 'author')
    	->where('status = 0')
    	->order('created desc')
    	->limit(10);
    	$resultSet = $this->_dbTable->fetchAll($select);
    
    	return $this->convertRows($resultSet);
    }
    
    public function getAuthors()
    {
    	$select = $this->_dbTable->select();
    	$select->where('role = ?', 'author')
        ->where('status < 3')
    	->order('created desc');
    	$resultSet = $this->_dbTable->fetchAll($select);
    
    	return $this->convertRows($resultSet);
    }

    public function getUsers()
    {
        $select = $this->_dbTable->select();
        $select->where('role = ?', 'user')
            ->where('status < 3')
            ->order('created desc');
        $resultSet = $this->_dbTable->fetchAll($select);

        return $this->convertRows($resultSet);
    }
    
    public function addPayment ($summ)
    {
    	$model_account = new Models_Accounts_Mapper();
    	$account = $model_account->getCurrent($this->id, 'model', $this->role);
    	$account->addSumm ($summ);
    }
    
    public function getNewUsers()
    {
    	$select = $this->_dbTable->select();
    	$select->where('role = ?', 'user')
    	->order('created desc')
        ->where('status < 3')
    	->limit(10);
    	$resultSet = $this->_dbTable->fetchAll($select);
    
    	return $this->convertRows($resultSet);
    }
    
    public function getSearch ($id = null)
    {
    	$select = $this->_dbTable->select();
    	$select->where('name LIKE ?', $id.'%')
            ->where('status < 3')
    	    ->limit(5, 0);
    	$resultSet = $this->_dbTable->fetchAll($select);
    
    	return $this->convertRows($resultSet);
    }
    
    public function getSearchUsers ($id = null, $type = false)
    {
    	$select = $this->_dbTable->select();
    	$select->where('name LIKE ?', $id.'%')
            ->where('status < 3')
    	    ->limit(5, 0);
        if($type){
            $select->where('role = ?', $type);
        }
    	$resultSet = $this->_dbTable->fetchAll($select);
    
    	return $this->convertRows($resultSet);
    }
    
    public function getSearchEmail ($email = null)
    {
    	$select = $this->_dbTable->select();
    	$select->where('email = ?', $email);
    	$this->_row = $this->_dbTable->fetchRow($select);
    
    	return $this;
    }
    
    public function getPaginator ($page = 1)
    {
    	$select = $this->_dbTable->select();
    	$select->where('role = ?', Zend_Registry::get('role'))
            ->where('status < 3');
    
    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	$paginator = new Zend_Paginator($adapter);
    	$paginator->setCurrentPageNumber($page);
    	$paginator->setItemCountPerPage ($this->_config->items_on_page);
    
    	return $paginator;
    }
    
    public function setThemes($options = NULL)
    {
    	$model = new Models_Tables_ThemesUsers();
    	$model->delete($model->getAdapter()->quoteInto('user_id = ?', $this->id));
    	if (count($options['themes']) > 0)
    	foreach ($options['themes'] as $theme){
    		$data = array(
    				'theme_id'=>$theme,
    				'user_id'=>$this->id
    		);
    		$model->insert($data);
    	}
    }
    
    public function getFiles ()
    {
        $model = new Models_Files_Mapper();
        return $model->convertRows($this->_row->findManyToManyRowset('Models_Files_Table', 'Models_Tables_FilesUsers'));
    }
    
    public function getThemes ()
    {
        $model_themes = new Models_Themescategories_Mapper();
        return $model_themes->convertRows($this->_row->findManyToManyRowset('Models_ThemesCategories_Table', 'Models_Tables_ThemesUsers'));
    }
    
    public function convertRow($row, $is_files = false)
    {
    	$entry = parent::convertRow($row);
        if ($is_files) {
            $entry->files = $row->getFiles();
        }
    	return $entry;
    }
    
    public function addFile($file_id = NULL)
    {
    	$model = new Models_Tables_FilesUsers();
    	$data = array(
    			'file_id'=>$file_id,
    			'user_id'=>$this->id
    	);
    	$model->insert($data);
    }
    
    public function save()
    {
    	Classes_Cache::clear(array('users'));
    	parent::save();
    }
    
    public function delete($id)
    {
    	Classes_Cache::clear(array('users'));
    	parent::delete($id);
    }
    
}

?>