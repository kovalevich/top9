<?php

class UniversController extends Zend_Controller_Action
{

    private $_config;

    public function init()
    {
        $container = $this->view->navigation()->getContainer();
        $page = $container->findOneBy ('controller','ratings');
        $page->active = true;
        $this->_config = Zend_Registry::get('_config')->my;
    }

    public function indexAction()
    {
        $this->_redirect('/univers/all');
    }

    public function allAction()
    {
        $mapper = new Models_Univers_Mapper();
		$this->view->page = $mapper->getPageFull($this->_request->getParam('page',1));
		$this->view->univers = $mapper->convertRowsFull($this->view->page);
        $this->view->max_votes = $mapper->getMaxVotes();
        $this->view->start_place = ($this->_request->getParam('page',1) - 1) * $this->_config->on_page;
        $this->view->top_hits = $mapper->getTopByHits();
        $this->view->max_views = $this->view->top_hits[0]->hits;
        $this->view->top_desire = $mapper->getTopByDesire();
        $this->view->max_desire = $this->view->top_desire[0]->desire;
    }

    public function univerAction()
    {
        $mapper = new Models_Univers_Mapper();
        $univer = $mapper->getUniver($this->_request->getParam('id'), true);

        if ($univer->id !== NULL) {
            $univer->concurents = $mapper->getConcurents($univer->id, $univer->rating);
            $univer->place = $mapper->getPlace($univer->id);
        	$this->view->univer = $univer;
            $this->view->max_votes = $mapper->getMaxVotes();

            $this->view->meta_facebook = '
                <meta property="og:url" content="http://top9.by/univer/'. $univer->id .'" />
                <meta property="og:title" content="Идет голосование за лучший универ в Беларуси!" />
                <meta property="og:image" content="http://top9.by/img/univers/' . $univer->id . '.jpg" />
                <link rel="image_src" href="http://top9.by/img/univers/' . $univer->id . '.jpg" />
                <meta property="fb:app_id" content="250696105018131" />
				<meta property="og:updated_time" content="' . time() . '" />
                <meta property="og:description" content="' .
                sprintf('Я голосую за %s. %s уже набрал %s %s. Голосуй за свой универ!!!',
                    $univer->name,
                    $univer->name,
                    $univer->rating,
                    $this->view->bycounts($univer->rating, 'голос', 'голоса', 'голосов')) . '" />
            ';
            //$mapper->goUpdate();
        }
        else {
        	$this->_redirect('/univers/all');
        }
    }

}