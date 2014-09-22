<?php

class GetitemController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function preDispatch()
    {
    	$this->_helper->layout()->disableLayout();
    }

    public function indexAction()
    {
        // action body
    }

    public function universAction()
    {
        $model = new Models_Univers_Mapper();
        $univer = $model->getUniver($this->_request->getParam('id'));
        if ($univer->id !== NULL) {
            $soc = new Classes_Social();
            $votes = $soc->get('http://top9.by/univer/'.$univer->id);
            $desire = $soc->get('http://top9.by/univer/'.$univer->id. '/#desire');
            $model->upVotes($univer->id, $votes, $desire);
            
        	$this->view->univer = $univer;
            $this->view->desire = $this->_request->getParam('type') == 'desire' ? true : false;
        }
        else {
        	$this->_redirect('/errors/404');
        }
    }
    
    public function collegesAction()
    {
        $model = new Models_Colleges_Mapper();
        $college = $model->getCollege($this->_request->getParam('id'));
        if ($college->id !== NULL) {
            $soc = new Classes_Social();
            $votes = $soc->get('http://top9.by/college/'.$college->id);
            $desire = $soc->get('http://top9.by/college/'.$college->id. '/#desire');
            $model->upVotes($college->id, $votes, $desire);

            $this->view->college = $college;
            $this->view->desire = $this->_request->getParam('type') == 'desire' ? true : false;
        }
        else {
            $this->_redirect('/errors/404');
        }
    }

    public function citiesAction()
    {
        $model = new Models_Cities_Mapper();
        $city = $model->getCity($this->_request->getParam('id'));
        if ($city->id !== NULL) {
            $soc = new Classes_Social();
            $votes = $soc->get('http://top9.by/city/'.$city->id);
            $desire = $soc->get('http://top9.by/city/'.$city->id. '/#desire');
            $model->upVotes($city->id, $votes, $desire);

            $this->view->city = $city;
            $this->view->desire = $this->_request->getParam('type') == 'desire' ? true : false;
        }
        else {
            $this->_redirect('/errors/404');
        }
    }

}