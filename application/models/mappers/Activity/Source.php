<?php
/**
 * Activity Source data mapper
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Model
 * @subpackage Mapper
 */
class MaitreCorbeaux_Model_Mapper_Activity_Source
extends MaitreCorbeaux_Model_Mapper_AbstractMapper
implements MaitreCorbeaux_Model_Mapper_Activity_SourceInterface
{
    /**
     * Create an Activity Source model from a data array
     *
     * @param array $data
     * @return MaitreCorbeaux_Model_Activity_Source
     */
    protected function _createSourceModel(array $data)
    {
        $cleanData = array(
            'id' => isset($data['idActivitySource'])
                    ? $data['idActivitySource']
                    : null,
            'slug' => isset($data['slugActivitySource'])
                      ? $data['slugActivitySource']
                      : null,
            'name' => isset($data['nameActivitySource'])
                      ? $data['nameActivitySource']
                      : null,
            'link' => isset($data['linkActivitySource'])
                      ? $data['linkActivitySource']
                      : null
        );

        return new MaitreCorbeaux_Model_Activity_Source($cleanData);
    }

    /**
     * 
     * @return Zend_Db_Table_Abstract
     * @see MaitreCorbeaux_Model_Mapper_Activity_Source::getDbTable()
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->_dbTable =
                new MaitreCorbeaux_Model_DbTable_Activity_Source();
        }

        return $this->_dbTable;
    }

    /**
     *
     * @return MaitreCorbeaux_Model_Collection_Activity_Source
     * @see MaitreCorbeaux_Model_Mapper_Activity_SourceInterface::fetchAll()
     */
    public final function fetchAll()
    {
        $rowsetData = $this->getDbTable()
                           ->fetchAll()
                           ->toArray();

        $sourceCollection =
            new MaitreCorbeaux_Model_Collection_Activity_Source();

        foreach ($rowsetData as $rowData) {
            $sourceCollection->add($this->_createSourceModel($rowData));
        }

        return $sourceCollection;
    }
}