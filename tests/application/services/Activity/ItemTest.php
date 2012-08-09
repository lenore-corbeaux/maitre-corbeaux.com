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

    public function testFetchLast()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    public function testPaginateAll()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    public function testPaginateAllIn()
    {
        $this->markTestIncomplete('Not yet implemented');
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