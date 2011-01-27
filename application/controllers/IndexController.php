<?php
/**
 * Index Controller
 */
class IndexController extends Zend_Controller_Action
{
    /**
     * Display the home page
     */
    public function indexAction()
    {
	    $this->view
             ->headTitle('Site personnel de Lucas Corbeaux développeur senior sur Angers', 'PREPEND');
    }
}

