<?php
/**
 * Abstract class for importing Activity Item from feed
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 * @see MaitreCorbeaux_Service_AbstractService
 * @see MaitreCorbeaux_Service_Activity_Import_ImportInterface
 */
abstract class MaitreCorbeaux_Service_Activity_Import_Feed
extends MaitreCorbeaux_Service_AbstractService
implements MaitreCorbeaux_Service_Activity_Import_ImportInterface
{
    /**
     *
     * @var string
     */
    protected $_feedUrl;

    /**
     *
     * @var Zend_Feed_Abstract
     */
    protected $_feed;

    /**
     * Convert the feed entry into an Activity Item model
     *
     * @param Zend_Feed_Entry_Abstract $item
     * @return MaitreCorbeaux_Model_Activity_Item
     */
    abstract protected function _createActivityItem(Zend_Feed_Entry_Abstract $item);

    /**
     *
     * @return MaitreCorbeaux_Model_Collection_Activity_Item
     * @see MaitreCorbeaux_Service_Activity_Import_ImportInterface::import()
     */
    public function import()
    {
        $feed = $this->getFeed();
        $collection = new MaitreCorbeaux_Model_Collection_Activity_Item();

        foreach ($feed as $item) {
            $collection->add($this->_createActivityItem($item));
        }

        return $collection;
    }

    /**
     *
     * @return string
     */
    public function getFeedUrl()
    {
        return $this->_feedUrl;
    }

    /**
     *
     * @param string $value
     * @return MaitreCorbeaux_Service_Activity_Import_Feed
     */
    public function setFeedUrl($value)
    {
        $this->_feedUrl = (string) $value;
    }

    /**
     *
     * @return Zend_Feed_Abstract
     */
    public function getFeed()
    {
        if (null === $this->_feed) {
            $this->_feed = Zend_Feed::import($this->_feedUrl);
        }

        return $this->_feed;
    }

    /**
     *
     * @param Zend_Feed_Abstract $feed
     * @return MaitreCorbeaux_Service_Activity_Import_Feed
     */
    public function setFeed(Zend_Feed_Abstract $feed)
    {
        $this->_feed = $feed;
    }
}