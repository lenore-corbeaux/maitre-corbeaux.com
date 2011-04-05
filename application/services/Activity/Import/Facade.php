<?php
/**
 * Facade to help importing Items from every Sources :
 * - Fetch Activity Sources from Activity Source service layer
 * - Acts as a factory for Activity Import services
 * - Handle import exceptions and log them
 * - Send every Items imported to the Activity Item service layer
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 * @see MaitreCorbeaux_Service_AbstractService
 * @see MaitreCorbeaux_Service_Activity_Import_ImportInterface
 */
class MaitreCorbeaux_Service_Activity_Import_Facade
extends MaitreCorbeaux_Service_AbstractService
implements MaitreCorbeaux_Service_Activity_Import_ImportInterface
{
    /**
     *
     * @var MaitreCorbeaux_Model_Collection_Activity_Source
     */
    protected $_sources;

    /**
     *
     * @var Zend_Log
     */
    protected $_log;

    /**
     *
     * @var Zend_Cache_Core
     */
    protected $_cache;

    /**
     * Log information in any logger available
     *
     * @param string $message
     * @param int $priority
     * @return void
     */
    protected function _log($message, $priority = Zend_Log::INFO)
    {
        $log = $this->getLog();

        if (null === $log) {
            return;
        }

        $message = (string) $message;
        $log->log($message, $priority);
    }

    /**
     * Import Activity Items from every Activity Sources
     *
     * @return MaitreCorbeaux_Service_Activity_Import_Facade
     * @see MaitreCorbeaux_Service_Activity_Import_ImportInterface::import()
     */
    public function import()
    {
        $service = new MaitreCorbeaux_Service_Activity_Item();
        $sources = $this->getSources();

        $this->_log('Start of activity items import');

        foreach ($sources as $source) {
            $slug = $source->getSlug();
            
            /*
             * We handle exception here, because we don't want an error
             * in an activity source to stop importing the others
             */
            try {
                $importer = $this->factory($source);
                $this->_log("Start of $slug import");
                $items = $importer->import();

                foreach ($items as $item) {
                    $this->_log('Import item ' . $item->getExternalId());
                    $item->setSource($source);
                    $service->import($item);
                }
            } catch (MaitreCorbeaux_Service_Activity_Import_Exception $e) {
                $this->_log($e, Zend_Log::CRIT);
            } catch (Zend_Exception $e) {
                $this->_log($e, Zend_Log::ERR);
            }
            
            $this->_log("End of $slug import");
        }

        $this->_log('Cleaning activity cache');
        $cache = $this->getCache();        
        $cache->clean('matchingTag', array('activity'));

        $this->_log('End of activity items import');
        return $this;
    }

    /**
     * Factory method for getting an import class from an Activity Source model
     *
     * @param MaitreCorbeaux_Model_Activity_Source $source
     */
    public function factory(MaitreCorbeaux_Model_Activity_Source $source)
    {
        $slug = $source->getSlug();
        $className = 'MaitreCorbeaux_Service_Activity_Import_'
                   . ucfirst($slug);

        return new $className();
    }

    /**
     *
     * @return MaitreCorbeaux_Model_Collection_Activity_Source
     */
    public function getSources()
    {
        if (null === $this->_sources) {
            $service = new MaitreCorbeaux_Service_Activity_Source();
            $this->_sources = $service->fetchAll();
        }

        return $this->_sources;
    }

    /**
     *
     * @param MaitreCorbeaux_Model_Collection_Activity_Source $value
     * @return MaitreCorbeaux_Service_Activity_Import_Facade
     */
    public function setSources(
        MaitreCorbeaux_Model_Collection_Activity_Source $value
    )
    {
        $this->_sources = $value;
    }

    /**
     *
     * @return Zend_Log
     */
    public function getLog()
    {
        if (null === $this->_log) {
            $bootstrap = $this->getBootstrap();
            $this->_log = $bootstrap->getResource('log');
        }

        return $this->_log;
    }

    /**
     *
     * @param Zend_Log $log
     * @return MaitreCorbeaux_Service_Activity_Import_Facade
     */
    public function setLog(Zend_Log $log)
    {
        $this->_log = $log;
        return $this;
    }

    /**
     *
     * @return Zend_Cache_Core
     */
    public function getCache()
    {
        if (null === $this->_cache) {
            $manager = $this->getBootstrap()
                            ->getResource('Cachemanager');
            
            $this->_cache = $manager->getCache(Zend_Cache_Manager::PAGECACHE);
        }

        return $this->_cache;
    }

    /**
     *
     * @param Zend_Cache_Core $value
     * @return MaitreCorbeaux_Service_Activity_Import_Facade
     */
    public function setCache(Zend_Cache_Core $value)
    {
        $this->_cache = $value;
        return $this;
    }
}