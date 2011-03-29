<?php
/**
 * Base class for Database test case
 */
abstract class DatabaseTestCase extends Zend_Test_PHPUnit_DatabaseTestCase
{
    /**
     * @var mixed Bootstrap file path or callback
     */
    public $bootstrap;

    /**
     *
     * @var PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected $_connectionMock;

    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV,
                                                APPLICATION_PATH
                                                . '/configs/application.ini');

        parent::setUp();
    }

    /**
     * Returns the test database connection
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
        if(null === $this->_connectionMock) {
            $bootstrap = $this->bootstrap
                              ->getBootstrap();

            $bootstrap->bootstrap('Db');
            $connection = $bootstrap->getResource('Db');
            
            $this->_connectionMock = $this->createZendDbConnection(
                $connection, 'maitrecorbeaux'
            );

            Zend_Db_Table_Abstract::setDefaultAdapter($connection);
        }
        
        return $this->_connectionMock;
    }

    /**
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return $this->createFlatXmlDataSet(
            TEST_PATH . '/_files/database/initialDataSet.xml'
        );
    }
}