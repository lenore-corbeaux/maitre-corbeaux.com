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
        $service = new MaitreCorbeaux_Service_Activity_Item();

        $this->view
             ->headTitle(
                'Site personnel de Lucas Corbeaux développeur senior sur Angers',
                'PREPEND'
             );

        $this->view->activityItems = $service->fetchLast();
    }
}

