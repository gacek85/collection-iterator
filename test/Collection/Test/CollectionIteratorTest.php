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
    
}