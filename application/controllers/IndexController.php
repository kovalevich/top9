<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {   

    }

    public function indexAction()
    {
        $votes = array('univers'=>0, 'colleges'=>0, 'cities'=>0);

        $mapper_univers = new Models_Univers_Mapper();
        $votes['univers'] = $mapper_univers->getCountVotes();
        $this->view->top_univers = $mapper_univers->getTopByCount(3);

        $mapper_colleges = new Models_Colleges_Mapper();
        $votes['colleges'] = $mapper_colleges->getCountVotes();
        $this->view->top_colleges = $mapper_colleges->getTopByCount(3);

        $mapper_cities = new Models_Cities_Mapper();
        $votes['cities'] = $mapper_cities->getCountVotes();
        $this->view->top_cities = $mapper_cities->getTopByCount(3);

        $summ = $votes['univers'] + $votes['colleges'] + $votes['cities'];

        $this->view->votes = $votes;
        $this->view->summ = $summ;
        $this->view->proc = round((100 / 80000) * $summ, 0);

    }

}
