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
     * @var MaitreCorbeaux_Model_Mapper_AbstractMapper
     */
    protected  $_mapper;

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

    /**
     * Always returns null
     *
     * This method is used as a Factory Method, so child class is
     * responsible of the type of mapper to instantiate by default.
     * 
     * @return MaitreCorbeaux_Model_Mapper_AbstractMapper
     */
    public  function getMapper()
    {
        return null;
    }

    /**
     *
     * @param MaitreCorbeaux_Model_Mapper_AbstractMapper $value
     * @return MaitreCorbeaux_Service_AbstractService
     */
    public  function setMapper(MaitreCorbeaux_Model_Mapper_AbstractMapper $value)
    {
        $this->_mapper = $value;
        return $this;
    }
}