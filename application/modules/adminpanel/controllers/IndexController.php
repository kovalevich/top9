<?php

class Adminpanel_IndexController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        if(!$articles = Classes_Cache::get('newarticlesadmin')){
            $model_articles = new Models_Articles_Mapper();
            $articles = $model_articles->getUnpublic();
            Classes_Cache::save($articles, 'newarticlesadmin', array('articles'));
        }
        $this->view->articles = $articles;

        if(!$sites = Classes_Cache::get('newsitesadmin')){
            $model_sites = new Models_Sites_Mapper();
            $sites = $model_sites->getUnpublic();
            Classes_Cache::save($sites, 'newsitesadmin', array('sites'));
        }
        $this->view->sites = $sites;

        $votes = array('univers'=>0, 'colleges'=>0, 'cities'=>0);

        $mapper_univers = new Models_Univers_Mapper();
        $votes['univers'] = $mapper_univers->getCountVotes();

        $mapper_colleges = new Models_Colleges_Mapper();
        $votes['colleges'] = $mapper_colleges->getCountVotes();

        $mapper_cities = new Models_Cities_Mapper();
        $votes['cities'] = $mapper_cities->getCountVotes();

        $this->view->votes = $votes;
    }

}

