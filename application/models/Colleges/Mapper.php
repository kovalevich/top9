<?php

class Models_Colleges_Mapper extends Models_Mapper
{

    public function __construct($id = null)
    {
        parent::__construct('Colleges');
        if ($id) {
            $this->getRow($id);
        }
        return $this;
    }

    public function goUpdate()
    {
        $select = $this->_dbTable->select()
            ->from($this->_dbTable->getName(), array('*'));
        $colleges = $this->_dbTable->fetchAll ($select);

        foreach($colleges as $college) {
            $this->upVotes($college['id'], $college['votes'], $college['desire']);
        }
    }

    public function getTopByCount($count = 9)
    {
        $db = $this->_dbTable->getDefaultAdapter();
        $select = $db->select()
            ->from (array('college'=>'colleges'), array('*'))
            ->joinLeft(array('city'=>'cities'), 'city.id = college.city_id', array(
                'city_id'=>'id',
                'city_name'=>'name'
            ))
            ->limit($count)
            ->order(array('college.rating desc'));

        $res = $db->fetchAll($select);

        return $this->convertRowsFull($res);
    }

    public function getTopByHits($count = 5)
    {
        $db = $this->_dbTable->getDefaultAdapter();
        $select = $db->select()
            ->from (array('college'=>'colleges'), array('*'))
            ->joinLeft(array('city'=>'cities'), 'city.id = college.city_id', array(
                'city_id'=>'id',
                'city_name'=>'name'
            ))
            ->limit($count)
            ->order(array('college.hits desc', 'college.rating desc'));

        $res = $db->fetchAll($select);

        return $this->convertRowsFull($res);
    }

    public function getTopByDesire($count = 5)
    {
        $db = $this->_dbTable->getDefaultAdapter();
        $select = $db->select()
            ->from (array('college'=>'colleges'), array('*'))
            ->joinLeft(array('city'=>'cities'), 'city.id = college.city_id', array(
                'city_id'=>'id',
                'city_name'=>'name'
            ))
            ->limit($count)
            ->order(array('college.desire desc', 'college.rating desc'));

        $res = $db->fetchAll($select);

        return $this->convertRowsFull($res);
    }

    public function getCollege($id = false, $is_view = false)
    {
        if (!$id)
            if ($this->_row->id)
                return $this->convertRow($this->_row);
            else return null;

        $select = $this->_db->select()
            ->from (array('college'=>'colleges'), array('*'))
            ->joinLeft(array('city'=>'cities'), 'city.id = college.city_id', array(
                'city_id'=>'id',
                'city_name'=>'name'
            ))
            ->where('college.id = ?', $id)
            ->limit(1);

        $res = $this->_db->fetchRow($select);

        if($is_view) {
            $this->update('colleges', array('hits'=>$res['hits']+1), array('id = "' . $id . '"'));
        }

        return $this->convertRowFull($res);
    }

    public function getAll()
    {
        $resultSet = $this->_dbTable->fetchAll();

        return $this->convertRows($resultSet);
    }

    public function getCountVotes()
    {
        $select = $this->_dbTable->select()
            ->from($this->_dbTable->getName(), array('votes'=>'sum(votes)'))
            ->order (array ('votes DESC'));
        $votes = $this->_dbTable->fetchRow ($select);
        return $votes->votes;
    }

    public function getTop ()
    {
        Zend_Registry::get('dbAdapter')->query('select @p := 0');
        $select = $this->_dbTable->select()
            ->from($this->_dbTable->getName())
            ->columns(array('*', 'place'=>'(@p := @p + 1)'))
            ->order (array ('votes DESC', 'name'))
            ->limit ($this->_config->count_on_top, 0);

        $resultSet = $this->_dbTable->fetchAll ($select);

        return $this->convertRows($resultSet);
    }

    public function getPage($page)
    {
        $select = $this->_dbTable->select()->order (array ('votes DESC', 'name'));

        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage ($this->_config->on_page);

        return $paginator;
    }

    public function getPageFull($page)
    {
        $select = $this->_db->select()
            ->from (array('college'=>'colleges'), array('*'))
            ->joinLeft(array('city'=>'cities'), 'city.id = college.city_id', array(
                'city_id'=>'id',
                'city_name'=>'name'
            ))
            ->order (array ('college.rating DESC', 'college.name'));

        $adapter = new Zend_Paginator_Adapter_DbSelect($select);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage ($this->_config->on_page);

        return $paginator;
    }

    public function getConcurents ($id, $rating) {

        $leftgr = $rating - $this->_config->proc*$rating;
        $rightgr = $rating + $this->_config->proc*$rating;
        $count = $this->_config->concurents;

        $select = $this->_db->select()
            ->from (array('college'=>'colleges'), array('*'))
            ->joinLeft(array('city'=>'cities'), 'city.id = college.city_id', array(
                'city_id'=>'id',
                'city_name'=>'name'
            ))
            ->where ("college.id != '".$id."' AND college.rating >= ". $leftgr." AND college.rating < ".$rightgr)
            ->order (array ('college.rating DESC', 'college.name'))
            ->limit ($count, 0);

        $resultSet = $this->_db->fetchAll ($select);
        return $this->convertRowsFull($resultSet);

    }

    public function getMaxVotes()
    {
        if(!$max_votes = Classes_Cache::get('max_colleges_votes')){
            $select = $this->_db->select()
                ->from (array('college'=>'colleges'), array('max'=>'college.rating'))
                ->limit(1)
                ->order(array('college.rating desc'));

            $res = $this->_db->fetchRow($select);
            $max_votes = $res['max'];
            Classes_Cache::save($max_votes, 'max_colleges_votes', null, 3600);
        }
        return $max_votes;
    }

    public function getMaxViews()
    {
        if(!$max_views = Classes_Cache::get('max_colleges_views')){
            $select = $this->_db->select()
                ->from (array('college'=>'colleges'), array('max'=>'college.hits'))
                ->limit(1)
                ->order(array('college.hits desc'));

            $res = $this->_db->fetchRow($select);
            $max_votes = $res['max'];
            Classes_Cache::save($max_votes, 'max_colleges_views', null, 3600);
        }
        return $max_views;
    }

    public function upVotes ($id = false, $votes, $desire) {

        $data = array (
            'votes' => $votes,
            'desire' => $desire,
            'rating' => $votes + $desire
        );
        $where[] = 'id = "' . $id . '"';
        $this->update('colleges', $data, $where);
    }

    public function clearViews () {

        $data = array (
            'hits' => 0
        );
        $this->update('colleges', $data, null);
    }

    public function convertRow ($row){

        $entry = parent::convertRow($row);

        $city_row = $row->findParentRow('Models_Cities_Table', 'city')->toArray();
        $entry->city = new Models_Cities_Model($city_row);
        $entry->place = $this->getPlace($row->id);

        return $entry;
    }

    public function convertRowFull($row)
    {
        $entry = parent::convertRowFull($row);

        $entry->city = new Models_Cities_Model(array(
            'id'=>$row['city_id'],
            'name'=>$row['city_name']
        ));

        return $entry;
    }

    public function getPlace($id)
    {
        Zend_Registry::get('dbAdapter')->query ('select @p := 0, @pp := 0;');
        $select = $this->_dbTable->select()
            ->from($this->_dbTable->getName(),
                array('(@p := @p + 1)', '(@pp := if (`id` = "'.$id.'", @p, @pp))'))
            ->order (array ('votes DESC', 'name'))
            ->query();
        $select = $this->_dbTable->select()
            ->from($this->_dbTable->getName(),
                array('place'=>'(@pp)'))
            ->where ('`id` = ?', $id);
        $res = $this->_dbTable->fetchRow ($select);
        return $res->place;

    }

    public function getSearch ($word = false) {
        $select = $this->_dbTable->select()
            ->where ("name LIKE '%".$word."%'")
            ->order ('votes DESC', 'name');
        $resultSet = $this->_dbTable->fetchAll ($select);

        return $this->convertRows($resultSet);
    }

}

?>