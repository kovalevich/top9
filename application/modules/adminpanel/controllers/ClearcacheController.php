<?php

class Adminpanel_ClearcacheController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
		$model_categories = new Models_Categories_Mapper();
        $categories = $model_categories->getAll();
        foreach($categories as $category) {
            $models_articles = new Models_Articles_Mapper();
            $articles = $models_articles->getAllArticles($category->id);

            $models_sites = new Models_Sites_Mapper();
            $sites = $models_sites->getAllArticles($category->id);

            $model_categories->getRow($category->id);
            $model_categories->count = count($articles);
            $model_categories->sites_count = count($sites);
            $model_categories->save();
        }
        Classes_Cache::clear();
    }


}

