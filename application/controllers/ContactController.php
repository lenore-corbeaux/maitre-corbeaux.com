<?php
/**
 * Contact controller
 * 
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Controller
 */
class ContactController extends Zend_Controller_Action
{
    /**
     * Define the Head Title
     * 
     * @return void
     */
    public function init()
    {
        $this->view
             ->headTitle(
                'Contactez Lucas Corbeaux, développeur senior sur Angers',
                'PREPEND'
             );
    }

    public function indexAction()
    {
        $service = new MaitreCorbeaux_Service_Contact();

        if ($this->_request->isPost()
            && $service->send($this->_request->getPost())) {
            $this->_helper
                 ->redirector('confirm');
        }

        $this->view->form = $service->getForm();
    }

    public function confirmAction()
    {}
}