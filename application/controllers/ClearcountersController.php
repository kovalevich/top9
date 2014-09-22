<?php

class ClearcountersController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        $mapper = new Models_Univers_Mapper();
        $mapper->clearViews();

        $mapper = new Models_Colleges_Mapper();
        $mapper->clearViews();

        $mapper = new Models_Cities_Mapper();
        $mapper->clearViews();
    }

}