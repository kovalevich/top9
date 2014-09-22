<?php 

class Models_Users_Model extends Models_Model
{
    
    public $id, $name, $email, $phone, $role, $city, $about, $password, $ballance, $created, $modified, $last_visit, $last_buy, $status, $files;
    
    public function __construct(array $options = null)
    {
        parent::__construct($options);
    }
    
    public function getThemes()
    {
        $model_user = new Models_Users_Mapper($this->id);
        return $model_user->getThemes();
    }
    
    public function getFiles()
    {
    	$model_files = new Models_Users_Mapper($this->id);
    	return $model_files->getFiles();
    }
    
}

?>