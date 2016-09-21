<?php
namespace Gacek85\Collection;

use Iterator;

/**
 *  Adapts a data source to the needs of 
 *  CollectionIterator
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
interface IterableDataProvider 
{

    const DEFAULT_LIMIT = 50;
    
    const DEFAULT_OFFSET = 0;

    /**
     * Returns total count of the elements that will be iterated
     * 
     * @return int
     */
    public function getTotal();
    
    
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
    );
}