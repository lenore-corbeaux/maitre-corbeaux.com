<?php
/**
 * ActivityItem table
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Model
 * @see Zend_Db_Table_Abstract
 */
class MaitreCorbeaux_Model_DbTable_Activity_Item extends Zend_Db_Table_Abstract
{
    /**
     *
     * @var string
     */
    protected $_name = 'ActivityItem';

    /**
     *
     * @var string
     */
    protected $_referenceMap = array(
        'ActivitySource' => array(
            'columns' => 'idActivitySourceActivityItem',
            'refTableClass' => 'MaitreCorbeaux_Model_DbTable_Activity_Source',
            'refColumns' => 'idActivitySource'
        )
    );
}