<?php
/**
 * Test class for MaitreCorbeaux_Service_Activity_Item
 * 
 */
class MaitreCorbeaux_Service_Activity_ItemTest
extends PHPUnit_Framework_TestCase
{
    /**
     * Activity Item service
     * 
     * @var MaitreCorbeaux_Service_Activity_Item
     */
    protected $_service;
    
    static public function dataProvider()
    {
        return array(
            array(
                array(
                    'title' => '<h1>Title</h1>',
                    'description' => '<p>Description</p>'
                ),
                array(
                    'title' => 'Title',
                    'description' => 'Description'
                )
            ),
            array(
                array(
                    'title' => '&lt;h1&gt;Title&lt;/h1&gt;',
                    'description' => '&lt;p&gt;Description&lt;/p&gt;'
                ),
                array(
                    'title' => 'Title',
                    'description' => 'Description'
                )
            ),
            array(
                array(
                    'title' => ' Title ',
                    'description' => ' Description '
                ),
                array(
                    'title' => 'Title',
                    'description' => 'Description'
                )
            ),
        );
    }
    
    static public function itemProvider()
    {
        return array(
            array(
                null
            ),
            array(
                new MaitreCorbeaux_Model_Activity_Item(array('id' => 123))
            )
        );
    }
    
    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $mapper = $this->getMock('MaitreCorbeaux_Model_Mapper_Activity_Item');
        $this->_service = new MaitreCorbeaux_Service_Activity_Item();
        $this->_service->setMapper($mapper);
    }
    
    /**
     * 
     * @dataProvider dataProvider
     */
    public function testCleanImportData($actual, $expected)
    {
        $model = new MaitreCorbeaux_Model_Activity_Item($actual);
        $this->_service->cleanImportData($model);
        $actual = array_intersect_key($model->toArray(), $expected);
        $this->assertSame($expected, $actual);
    }

    /**
     * 
     * @dataProvider itemProvider
     */
    public function testImportActivityItem(
        MaitreCorbeaux_Model_Activity_Item $existingItem = null
    )
    {
        $mapper = $this->_service->getMapper();
        $externalId = 'foo';
        
        $item = $this->getMock('MaitreCorbeaux_Model_Activity_Item');
        $source = $this->getMock('MaitreCorbeaux_Model_Activity_Source');
        
        $item->expects($this->once())
             ->method('getExternalId')
             ->will($this->returnValue($externalId));
             
        $item->expects($this->once())
             ->method('getSource')
             ->will($this->returnValue($source));
               
        if (null !== $existingItem) {
            $item->expects($this->once())
                 ->method('setId')
                 ->with($this->equalTo($existingItem->getId()));
        }
        
        $service = $this->getMock(
            'MaitreCorbeaux_Service_Activity_Item',
            array('cleanImportData', 'getMapper')
        );
        
        $service->expects($this->once())
                ->method('getMapper')
                ->will($this->returnValue($mapper));
                
        $service->expects($this->once())
                ->method('cleanImportData')
                ->with($item);
                
        $mapper->expects($this->once())
               ->method('findByExternalId')
               ->with($this->equalTo($externalId), $this->equalTo($source))
               ->will($this->returnValue($existingItem));
               
        $mapper->expects($this->once())
               ->method('save')
               ->with($this->equalTo($item));
               
        $service->import($item);
    }

    /**
     * Prepare bootstrap configuration.
     * 
     * @param mixed $value The option value.
     * @return void
     */
    protected function _prepareBootstrap($value)
    {
        $bootstrap = $this->getMock(
            'Zend_Application_Bootstrap_BootstrapAbstract',
            array(), array(), '', false
        );
        
        $bootstrap->expects($this->once())
                  ->method('getOption')
                  ->with($this->equalTo('activityItem'))
                  ->will($this->returnValue($value));
                  
        $this->_service->setBootstrap($bootstrap);
    }
    
    /**
     * Prepare mapper for fetch and paginate calls.
     * 
     * @param string $method The method name.
     * @param array $params The parameters given to method.
     * @return MaitreCorbeaux_Model_Collection_Activity_Item
     */
    protected function _prepareMapper($method, array $params)
    {
        $collection = new MaitreCorbeaux_Model_Collection_Activity_Item();
        
        $mapper = $this->_service->getMapper();
        $method = $mapper->expects($this->once())
                         ->method($method);
        
        call_user_func_array(array($method, 'with'), $params);
                         
        $method->will($this->returnValue($collection));
        return $collection;
    }

    public function testFetchLast()
    {
        $nbLast = 123;
        
        $this->_prepareBootstrap(array('nbLast' => $nbLast));
        $expected = $this->_prepareMapper('fetchLast', array($nbLast));
        
        $actual = $this->_service->fetchLast();
        $this->assertSame($expected, $actual);
    }

    public function testPaginateAll()
    {
        $page = 123;
        $nbPaginator = 456;
        
        $this->_prepareBootstrap(array('nbPaginator' => $nbPaginator));
        
        $expected = $this->_prepareMapper(
            'paginateAll', array($page, $nbPaginator)
        );
        
        $actual = $this->_service->paginateAll($page);
        $this->assertSame($expected, $actual);
    }

    public function testPaginateAllIn()
    {
        $ids = array(1, 2, 3);
        $page = 123;
        $nbPaginator = 456;
        
        $this->_prepareBootstrap(array('nbPaginator' => $nbPaginator));
        $expected = $this->_prepareMapper(
            'paginateAllIn', array($ids, $page, $nbPaginator)
        );
        
        $actual = $this->_service->paginateAllIn($ids, $page);
        $this->assertSame($expected, $actual);
    }
    
    public function testFetchAllCallMapperFetchAll()
    {
        $items = new MaitreCorbeaux_Model_Collection_Activity_Item();
        
        $this->_service
             ->getMapper()
             ->expects($this->once())
             ->method('fetchAll')
             ->will($this->returnValue($items));
             
        $newItems = $this->_service->fetchAll();
        $this->assertSame($items, $newItems);
    }

    /**
     * TestCase tear down
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->_service);
    }
}