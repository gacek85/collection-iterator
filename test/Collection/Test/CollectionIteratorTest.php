<?php
namespace Gacek85\Collection\Test;

use Gacek85\Collection\CollectionIterator;
use Gacek85\Collection\Test\Mock\Factory;
use PHPUnit_Framework_TestCase;

/**
 *  Test case for CollectionIterator
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class CollectionIteratorTest extends PHPUnit_Framework_TestCase 
{

    const TEST_LENGTH = 10000;
    
    /**
     * Tests the count method
     */
    public function testCount()
    {
        // Test with 10 elements
        list($rawArray, $dataProvider) = Factory::getMock(10);
        $iterator = new CollectionIterator($dataProvider);
        $this->assertEquals(count($rawArray), $iterator->count());
        
        // Test with 0 elements
        list($rawArray0, $dataProvider0) = Factory::getMock(0);
        $iterator0 = new CollectionIterator($dataProvider0);
        $this->assertEquals(count($rawArray0), count($iterator0));
    }

    /**
     * Tests the iteration
     */
    public function testCollectionIterator()
    {
        list($rawArray, $dataProvider) = Factory::getMock(self::TEST_LENGTH);
        $iterator = new CollectionIterator($dataProvider);
        $counter = 0;
        foreach ($iterator as $k => $value) {
            $this->assertEquals($rawArray[$counter], $value);
            $this->assertEquals($counter++, $k);
        }
    }
    
    /**
     * Tests reset
     */
    public function testReset()
    {
        list($rawArray, $dataProvider) = Factory::getMock(5);
        $iterator = new CollectionIterator($dataProvider);
        $iterator->setPerPage(1);
        foreach ($iterator as $k => $value) {};
        $iterator->reset();
        foreach ($iterator as $k => $value) {
            $this->assertEquals($rawArray[$k], $value);
        }
    }
    
}