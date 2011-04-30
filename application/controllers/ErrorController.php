<?php
/**
 * Error Controller
 *
 * Display and log error messages
 *  
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Controller
 */
class ErrorController extends Zend_Controller_Action
{
    /**
     * Return the Log resource if available
     * 
     * @return  Zend_Log|false
     */
    protected function _getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');

        if (!$bootstrap->hasResource('Log')) {
            return false;
        }

        return $bootstrap->getResource('Log');
    }

    /**
     * Display the error page and log the error message
     */
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

        if (!$errors) {
            $this->view->message = "Page d'erreur";
            return;
        }

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:        
                $this->getResponse()
                     ->setHttpResponseCode(404);

		        $this->view
		             ->headTitle('404 - page non trouvée', 'PREPEND');

                $this->view
                     ->message = 'Page non trouvée';

		        $priority = Zend_Log::NOTICE;
                break;

            default:
                $this->getResponse()
                     ->setHttpResponseCode(500);

		        $this->view
		             ->headTitle('500 - une erreur est survenue', 'PREPEND');

                $this->view
                     ->message = "Une erreur est survenue durant votre navigation";

		        $priority = Zend_Log::ERR;
                break;
        }
        
        if ($log = $this->_getLog()) {
            $log->log($this->view->message, $priority, $errors->exception);
        }
        
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->request = $errors->request;
    }
}
