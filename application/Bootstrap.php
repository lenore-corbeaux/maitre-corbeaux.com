<?php
/**
 * Main Bootstrap class
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Initialize Google Analytics view helper
     * 
     * @return void
     */
    protected function _initGoogleAnalytics()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $options = $this->getOption('googleAnalytics');
        $view->googleAnalytics($options['accountId'], $options['mode']);
    }

    /**
     * Initialize ReCaptcha Service
     *
     * @return Zend_Service_ReCaptcha
     */
    protected function _initReCaptcha()
    {
        $options = $this->getOption('reCaptcha');
        $service = new Zend_Service_ReCaptcha($options['publicKey'],
                                              $options['privateKey']);
        return $service;
    }

    /**
     * Initialize Contact Form
     *
     * @return array
     */
    protected function _initContact()
    {
        $options = $this->getOption('contact');
        return $options;
    }
}
