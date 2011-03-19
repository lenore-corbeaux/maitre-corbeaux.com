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
}
