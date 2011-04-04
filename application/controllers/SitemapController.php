<?php
class SitemapController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->_helper->contextSwitch()
                      ->addActionContext('index', 'xml')
                      ->initContext('xml');

        // We remove "non-application" link from the Bootstrap
        $navigation = $this->view->getHelper('Navigation')
                                 ->getContainer();

        foreach ($navigation as $page) {
            if (!$page instanceof Zend_Navigation_Page_Mvc) {
                $navigation->removePage($page);
            }
        }
    }
}