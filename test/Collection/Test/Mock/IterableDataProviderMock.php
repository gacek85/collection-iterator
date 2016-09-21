<?php
namespace Gacek85\Collection\Test\Mock;

use Gacek85\Collection\IterableDataProvider;

/**
 *  Mock implementation of IterableDataProvider
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class IterableDataProviderMock implements IterableDataProvider 
{
    
    /**
     * @var array
     */
    protected $fakeData = null;
    
    public function __construct(array $fakeData)
    {
        $this->fakeData = $fakeData;
    }
    
    /**
     * Returns total count of the elements that will be iterated
     * 
     * @return int
     */
    public function getTotal()
    {
        return count($this->fakeData);
    }
    
    
    /**
     * Provides a chunk of data for given start and limit
     * 
     * @param       int             $offset
     * @param       int             $limit
     * @return      array|Iterator  Returns an iterable and countable collection
     */
    public function getChunk(
        $offset = IterableDataProvider::DEFAULT_OFFSET, 
        $limit = IterableDataProvider::DEFAULT_LIMIT
    ) {
        return array_slice($this->fakeData, $offset, $limit);
    }
}