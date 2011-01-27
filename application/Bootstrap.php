<?php
/**
 * Main Bootstrap class
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Initialize the Zend_Log options
     * 
     * @return void
     */
    protected function _initLogOptions()
	{
        $this->bootstrap('log');
        $log = $this->getResource('log');
        $options = $this->getOptions('log');

		if ($log instanceof Zend_Log && isset($options['log']['timestampFormat'])) {
            $log->setTimestampFormat($options['log']['timestampFormat']);
        }
    }
}
