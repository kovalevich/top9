<?php

class SitemapController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        if(!$categories = Classes_Cache::get('categories')){
            $model_categories = new Models_Categories_Mapper();
            $categories = $model_categories->getAll();
            Classes_Cache::save($categories, 'categories', array('categories', 'articles'));
        }
        $this->view->categories = $categories;

        if(!$articles = Classes_Cache::get('articles')){
            $model_articles = new Models_Articles_Mapper();
            $articles = $model_articles->getAllArticles();
            Classes_Cache::save($articles, 'articles', array('articles'));
        }
        $this->view->articles = $articles;

        if(!$sites = Classes_Cache::get('sites')){
            $model_sites = new Models_Sites_Mapper();
            $sites = $model_sites->getAllArticles();
            Classes_Cache::save($sites, 'sites', array('sites'));
        }
        $this->view->articles = $articles;

        if(!$univers = Classes_Cache::get('univers')){
            $model_univers = new Models_Univers_Mapper();
            $univers = $model_univers->getAll();
            Classes_Cache::save($univers, 'univers', array('univers'));
        }

        $this->view->categories = $categories;
        $this->view->sites = $sites;
        $this->view->articles = $articles;
    }

    public function xmlAction()
    {
        $this->_helper->layout()->disableLayout();

        if(!$categories = Classes_Cache::get('categories')){
            $model_categories = new Models_Categories_Mapper();
            $categories = $model_categories->getAll();
            Classes_Cache::save($categories, 'categories', array('categories', 'articles'));
        }
        $this->view->categories = $categories;

        if(!$articles = Classes_Cache::get('articles')){
            $model_articles = new Models_Articles_Mapper();
            $articles = $model_articles->getAllArticles();
            Classes_Cache::save($articles, 'articles', array('articles'));
        }
        $this->view->articles = $articles;

        if(!$sites = Classes_Cache::get('sites')){
            $model_sites = new Models_Sites_Mapper();
            $sites = $model_sites->getAllArticles();
            Classes_Cache::save($sites, 'sites', array('sites'));
        }
        $this->view->articles = $articles;

        if(!$univers = Classes_Cache::get('univers')){
            $model_univers = new Models_Univers_Mapper();
            $univers = $model_univers->getAll();
            Classes_Cache::save($univers, 'univers', array('univers'));
        }

        if(!$cities = Classes_Cache::get('cities')){
            $model_cities = new Models_Cities_Mapper();
            $cities = $model_cities->getAll();
            Classes_Cache::save($cities, 'cities', array('cities'));
        }

        if(!$colleges = Classes_Cache::get('colleges')){
            $model_colleges = new Models_Colleges_Mapper();
            $colleges = $model_colleges->getAll();
            Classes_Cache::save($colleges, 'colleges', array('cities'));
        }


        
        $pages = array();

        foreach ($articles as $item){
            $pages[] = array(
                'loc'=>'http://top9.by/articles/'.$item->category->id.'/'.$item->id.'.html',
                'lastmod'=>date("Y-m-d",$item->modified),
                'changefreq'=>'weekly',
                'priority'=>'0.5'
            );
        }

        foreach ($sites as $item){
            $pages[] = array(
                'loc'=>'http://top9.by/sites/'.$item->category->id.'/'.$item->id.'.html',
                'lastmod'=>date("Y-m-d",$item->created),
                'changefreq'=>'weekly',
                'priority'=>'0.5'
            );
        }

        foreach ($categories as $item){
            $pages[] = array(
                'loc'=>'http://top9.by/articles/'.$item->id.'_page_1.html',
                'lastmod'=>date("Y-m-d"),
                'changefreq'=>'daily',
                'priority'=>'0.5'
            );
        }

        foreach ($categories as $item){
            $pages[] = array(
                'loc'=>'http://top9.by/sites/'.$item->id.'_page_1.html',
                'lastmod'=>date("Y-m-d"),
                'changefreq'=>'daily',
                'priority'=>'0.5'
            );
        }
        
        foreach ($univers as $item) {
            $pages[] = array(
                    'loc'=>'http://top9.by/univer/'.$item->id,
                    'lastmod'=>date("Y-m-d"),
                    'changefreq'=>'daily',
                    'priority'=>'0.5'
            );  
        }
        
        foreach ($cities as $item) {
        	$pages[] = array(
        			'loc'=>'http://top9.by/city/'.$item->id,
        			'lastmod'=>date("Y-m-d"),
        			'changefreq'=>'daily',
        			'priority'=>'0.5'
        	);
        }
		
		foreach ($colleges as $item) {
        	$pages[] = array(
        			'loc'=>'http://top9.by/college/'.$item->id,
        			'lastmod'=>date("Y-m-d"),
        			'changefreq'=>'daily',
        			'priority'=>'0.5'
        	);
        }
		
		
        
        $this->view->pages = $pages;
    }


}



