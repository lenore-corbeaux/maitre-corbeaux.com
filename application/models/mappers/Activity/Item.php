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
     * Create an Activity Item model from a data array
     *
     * @param array $data
     */
    protected function _createItemModel(array $data)
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
        
        return new MaitreCorbeaux_Model_Activity_Item($cleanData);
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

        return $this->_createItemModel($rowset->current()->toArray());
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
        $dbTable = $this->getDbTable();

        $rowset = $dbTable->fetchAll(
            null, 'publicationDateActivityItem DESC', $nbItems
        );

        $collection = new MaitreCorbeaux_Model_Collection_Activity_Item();

        foreach ($rowset as $row) {
            $collection->add($this->_createItemModel($row->toArray()));
        }

        return $collection;
    }
}