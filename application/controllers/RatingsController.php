<?php

class RatingsController extends Zend_Controller_Action
{


    public function init()
    {

    }

    public function indexAction()
    {
        $this->view->headTitle('Народные рейтинги', 'PREPEND');

        $votes = array('univers'=>0, 'colleges'=>0, 'cities'=>0);

        $mapper_univers = new Models_Univers_Mapper();
        $votes['univers'] = $mapper_univers->getCountVotes();
        $this->view->top_univers = $mapper_univers->getTopByCount(9);

        $mapper_colleges = new Models_Colleges_Mapper();
        $votes['colleges'] = $mapper_colleges->getCountVotes();
        $this->view->top_colleges = $mapper_colleges->getTopByCount(9);

        $mapper_cities = new Models_Cities_Mapper();
        $votes['cities'] = $mapper_cities->getCountVotes();
        $this->view->top_cities = $mapper_cities->getTopByCount(9);

        $summ = $votes['univers'] + $votes['colleges'] + $votes['cities'];

        $this->view->votes = $votes;
        $this->view->summ = $summ;
        $this->view->proc = round((100 / 25000) * $summ, 0);
    }

    public function searchAction()
    {
        if ($this->_request->isPost()) {

            $model_univers = new Models_Univers_Mapper();
            $model_cities = new Models_Cities_Mapper();
            $model_colleges = new Models_Colleges_Mapper();

            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter = new Zend_Filter_StripTags();
            $word = $filter->filter($this->_request->getPost('search'));
            $word = trim($word);

            $this->view->univers = $model_univers->getSearch($word);
            $this->view->cities = $model_cities->getSearch($word);
            $this->view->colleges = $model_colleges->getSearch($word);
            $this->view->word = $word;

        }
    }

}

