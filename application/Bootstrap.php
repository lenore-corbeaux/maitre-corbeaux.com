<?php
/**
 * Main Bootstrap class
 * 
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Bootstrap
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

    /**
     * Initialize Paginator
     */
    protected function _initPaginator()
    {
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('_pagination-control.phtml');
        Zend_Paginator::setDefaultScrollingStyle('Elastic');
    }

    /**
     * Initialize Twitter configuration
     *
     * @return array
     */
    protected function _initTwitter()
    {
        $options = $this->getOption('twitter');
        return $options;
    }

    /**
     * Initialize profile
     *
     * @return MaitreCorbeaux_Model_Profile
     */
    protected function _initProfile()
    {
        $this->bootstrap('view');

        $profile = new MaitreCorbeaux_Model_Profile();
        $profile->setBirthDate(new Zend_Date('12-08-1983'));

        $view = $this->getResource('view');
        $view->profile = $profile;
        return $profile;
    }
}
