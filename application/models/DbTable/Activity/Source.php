<?php
/**
 * ActivitySource table
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Model
 * @see Zend_Db_Table_Abstract
 */
class MaitreCorbeaux_Model_DbTable_Activity_Source extends Zend_Db_Table_Abstract
{
    /**
     *
     * @var string
     */
    protected $_name = 'ActivitySource';

    /**
     *
     * @var string
     */
    protected $_dependentTables = array(
        'MaitreCorbeaux_Model_DbTable_Activity_Item'
    );
}