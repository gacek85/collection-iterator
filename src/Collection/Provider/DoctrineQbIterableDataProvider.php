<?php
namespace Gacek85\Collection\Provider;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Gacek85\Collection\IterableDataProvider;
use Iterator;

/**
 *  Data provider for Doctrine ORM. QueryBuilder aware.
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class DoctrineQbIterableDataProvider implements IterableDataProvider
{
    
    /**
     * @var QueryBuilder 
     */
    protected $qb = null;
    
    
    /**
     * Constructs the Doctrine QueryBuilder aware provider.
     * 
     * @param QueryBuilder $qb
     */
    public function __construct (QueryBuilder $qb)
    {
        $this->qb = $qb;
    }
    
    
    /**
     * Returns total count of the elements that will be iterated
     * 
     * @return int
     */
    public function getTotal()
    {
        return (new Paginator($this->getQuery()))->count();
    }
    
    
    /**
     * @return QueryBuilder
     */
    protected function cloneQb() 
    {
        return clone $this->qb;
    }
    
    /**
     * 
     * @return Query
     */
    protected function getQuery()
    {
        return $this->cloneQb()->getQuery();
    }
    
    
    /**
     * Provides a chunk of data for given start and limit
     * 
     * @param       int             $offset
     * @param       int             $limit
     * @return      array|Iterator  Returns an iterable and countable collection
     */
    public function getChunk (
        $offset = IterableDataProvider::DEFAULT_OFFSET, 
        $limit = IterableDataProvider::DEFAULT_LIMIT
    ) {
        return $this
                    ->cloneQb()
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();
    }
}