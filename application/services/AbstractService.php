<?php
/**
 * Base class for Service Layer
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 */
abstract class MaitreCorbeaux_Service_AbstractService
{
    /**
     *
     * @var Zend_Application_Bootstrap_BootstrapAbstract
     */
    protected $_bootstrap;

    /**
     *
     * @return Zend_Application_Bootstrap_BootstrapAbstract
     */
    public function getBootstrap()
    {
        if (null === $this->_bootstrap) {
            $frontController = Zend_Controller_Front::getInstance();
            $this->_bootstrap = $frontController->getParam('bootstrap');
        }

        return $this->_bootstrap;
    }

    /**
     *
     * @param Zend_Application_Bootstrap_BootstrapAbstract $bootstrap
     * @return MaitreCorbeaux_Service_AbstractService
     */
    public function setBootstrap(Zend_Application_Bootstrap_BootstrapAbstract
                                 $bootstrap)
    {
        $this->_bootstrap = $bootstrap;
        return $this;
    }
}