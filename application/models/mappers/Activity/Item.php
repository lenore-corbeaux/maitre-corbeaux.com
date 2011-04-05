<?php
/**
 * Activity Item data mapper
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Model
 */
class MaitreCorbeaux_Model_Mapper_Activity_Item
extends MaitreCorbeaux_Model_Mapper_AbstractMapper
implements MaitreCorbeaux_Model_Mapper_Activity_ItemInterface
{
    /**
     *
     * @var MaitreCorbeaux_Model_Mapper_Activity_SourceInterface
     */
    protected $_activitySourceMapper;

    /**
     * Return a join select between ActivityItem and ActivitySource table
     *
     * @return Zend_Db_Select
     */
    protected function _createSelect()
    {
        $itemDbTable = $this->getDbTable();
        $sourceDbTable = $this->getActivitySourceMapper()
                              ->getDbTable();

        $dbAdapter = $itemDbTable->getAdapter();

        $itemTableName = $dbAdapter->quoteIdentifier(
            $itemDbTable->info('name')
        );

        $sourceTableName = $dbAdapter->quoteIdentifier(
            $sourceDbTable->info('name')
        );

        $select = $dbAdapter->select();

        $cond = "$itemTableName.idActivitySourceActivityItem = "
              . "$sourceTableName.idActivitySource";

        $select->from($itemDbTable->info('name'))
               ->join($sourceDbTable->info('name'), $cond);

        return $select;
    }

    /**
     * Create an Activity Item model from a data array
     *
     * @param array $data
     * @return MaitreCorbeaux_Model_Activity_Item
     * @see MaitreCorbeaux_Model_Mapper_AbstractMapper::createModel()
     */
    public function createModel(array $data)
    {
        $cleanData = array(
            'id' => array_key_exists('idActivityItem', $data)
                    ? $data['idActivityItem']
                    : null,
            'title' => array_key_exists('titleActivityItem', $data)
                    ? $data['titleActivityItem']
                    : null,
            'description' => array_key_exists('descriptionActivityItem', $data)
                    ? $data['descriptionActivityItem']
                    : null,
            'link' => array_key_exists('linkActivityItem', $data)
                    ? $data['linkActivityItem']
                    : null,
            'externalId' => array_key_exists('externalIdActivityItem', $data)
                    ? $data['externalIdActivityItem']
                    : null,
            'publicationDate' => array_key_exists('publicationDateActivityItem', $data)
                    ? new Zend_Date(
                        $data['publicationDateActivityItem'],
                        'yyyy-MM-dd HH:mm:ss'
                    )
                    : null
        );
        
        $model = new MaitreCorbeaux_Model_Activity_Item($cleanData);

        // We use isset here, because we want only non-null value
        if (isset($data['idActivitySourceActivityItem'])) {
            $sourceMapper = $this->getActivitySourceMapper();
            $model->setSource($sourceMapper->createModel($data));
        }

        return $model;
    }

    /**
     * Create an Activity Item collection from a data array
     *
     * @param array $data
     * @return MaitreCorbeaux_Model_Collection_Activity_Item
     * @see MaitreCorbeaux_Model_Mapper_AbstractMapper::createCollection()
     */
    public function createCollection(array $data)
    {
        $collection = new MaitreCorbeaux_Model_Collection_Activity_Item();

        foreach ($data as $row) {
            $collection->add($this->createModel((array) $row));
        }

        return $collection;
    }

    /**
     *
     * @param string $externalId
     * @param MaitreCorbeaux_Model_Activity_Source $source
     * @return MaitreCorbeaux_Model_Activity_Item
     * @see MaitreCorbeaux_Model_Mapper_Activity_ItemInterface::findExternalId()
     */
    public function findByExternalId($externalId, MaitreCorbeaux_Model_Activity_Source $source)
    {
        $dbTable = $this->getDbTable();
        $rowset = $dbTable->fetchAll(
            array(
                'externalIdActivityItem = ?' => $externalId,
                'idActivitySourceActivityItem = ?' => $source->getId()
            )
        );

        if (!count($rowset)) {
            return null;
        }

        return $this->createModel($rowset->current()->toArray());
    }

    /**
     *
     *
     * @param MaitreCorbeaux_Model_Activity_Item $item
     * @return MaitreCorbeaux_Model_Mapper_Activity_Item
     * @see MaitreCorbeaux_Model_Mapper_Activity_ItemInterface::save()
     */
    public function save(MaitreCorbeaux_Model_Activity_Item $item)
    {
        $publicationDate = $item->getPublicationDate();

        if (null !== $publicationDate) {
            $publicationDate = $publicationDate->toString('yyyy-MM-dd HH:mm:ss');
        }

        $data = array(
            'titleActivityItem' => $item->getTitle(),
            'descriptionActivityItem' => $item->getDescription(),
            'linkActivityItem' => $item->getLink(),
            'externalIdActivityItem' => $item->getExternalId(),
            'publicationDateActivityItem' => $publicationDate
        );

        $source = $item->getSource();

        // If no source model, we don't update the source id
        if (null !== $source) {
            $data['idActivitySourceActivityItem'] = $source->getId();
        }

        $dbTable = $this->getDbTable();
        $id = $item->getId();

        if (null === $id) {
            $id = $dbTable->insert($data);
            $item->setId($id);
        } else {
            $dbTable->update($data, array('idActivityItem = ?' => $id));
        }
        
        return $this;
    }

    /**
     *
     * @param int $nbItems
     * @return MaitreCorbeaux_Model_Mapper_Activity_Item
     * @see MaitreCorbeaux_Model_Mapper_Activity_ItemInterface::fetchLatests()
     */
    public function fetchLast($nbItems)
    {
        $nbItems = (int) $nbItems;
        $select = $this->_createSelect();

        $select->order('publicationDateActivityItem DESC')
               ->limit($nbItems);

        $dbAdapter = $this->getDbTable()
                          ->getAdapter();

        $data = $dbAdapter->fetchAll($select);
        return $this->createCollection($data);
    }

    /**
     *
     * @param int $offset
     * @param int $itemCountPerPage
     * @return Zend_Paginator
     * @see MaitreCorbeaux_Model_Mapper_Activity_ItemInterface::paginateAll()
     */
    public function paginateAll($offset, $itemCountPerPage)
    {
        $select = $this->_createSelect();
        $select->order('publicationDateActivityItem DESC');

        return $this->_createPaginator($select, $offset, $itemCountPerPage);
    }

    /**
     *
     * @return Zend_Db_Table_Abstract
     * @see MaitreCorbeaux_Model_Mapper_Activity_Item::getDbTable()
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->_dbTable =
                new MaitreCorbeaux_Model_DbTable_Activity_Item();
        }

        return $this->_dbTable;
    }

    /**
     *
     * @return MaitreCorbeaux_Model_Mapper_Activity_SourceInterface
     * @see MaitreCorbeaux_Model_Mapper_Activity_Item::getDbTable()
     */
    public function getActivitySourceMapper()
    {
        if (null === $this->_activitySourceMapper) {
            $this->_activitySourceMapper =
                new MaitreCorbeaux_Model_Mapper_Activity_Source();
        }

        return $this->_activitySourceMapper;
    }

    /**
     *
     * @param MaitreCorbeaux_Model_Mapper_Activity_SourceInterface $value
     * @return MaitreCorbeaux_Model_Mapper_Activity_ItemInterface
     */
    public function setActivitySourceMapper(
        MaitreCorbeaux_Model_Mapper_Activity_SourceInterface $value
    )
    {
        $this->_activitySourceMapper = $value;
        return $this;
    }
}