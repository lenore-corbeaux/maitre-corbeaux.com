<?php

class ContactController extends Zend_Controller_Action
{
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