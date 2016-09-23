<?php
namespace Gacek85\Collection;

use Countable;
use Gacek85\Collection\IterableDataProvider;
use Iterator;

/**
 *  Enables iterating over big sets of data loaded in chunks
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class CollectionIterator implements Iterator, Countable
{
    const DEFAULT_PER_PAGE = 50;
    
    const FORCE_REINIT = true;
    
    private $perPage = self::DEFAULT_PER_PAGE;
    
    private $count = null;
    
    private $currentPage = null;

    private $currentIndex = null;
    
    private $pagesCount = null;
    
    private $loaded = null;
    
    private $loadedIndex = null;


    /**
     * @var IterableDataProvider 
     */
    private $dataProvider = null;
    
    
    public function __construct(IterableDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }
    
    
    /**
     * Resets the iterator
     * 
     * @return CollectionIterator
     */
    public function reset()
    {
        $this->count = null;
        $this->currentPage = null;
        $this->pagesCount = null;
        $this->currentIndex = null;
        $this->params = null;
        $this->loaded = null;
        $this->loadedIndex = null;
        
        return $this;
    }
    
    
    /**
     * Sets the amount of items that will be loaded from
     * the data source and kept in the memory at once
     * 
     * @param   int                 $perPage    By default 50
     * 
     * @return  CollectionIterator  This iterator
     */
    public function setPerPage($perPage = self::DEFAULT_PER_PAGE)
    {
        $this->perPage = $perPage;
        return $this;
    }
    
    

    
    /**
     * Return the current element
     * 
     * @return      mixed       Mixed, depending what the model returns
     */
    public function current()
    {
        return $this
                    ->init()
                    ->loaded[$this->loadedIndex++];
    }

    
    /**
     * Interface method, not implemented
     * 
     * @return      int
     */
    public function key()
    {
        return $this->currentIndex;
    }

    
    /**
     * Move forward to next element
     */
    public function next()
    {
        if ($this->init()->shouldLoadNext()) {
            $this->loadNext();
        }
        $this->currentIndex++;
    }

    
    /**
     * Rewind the Iterator to the first element
     */
    public function rewind()
    {
        $this->init(self::FORCE_REINIT);
    }

    
    /**
     * Validates current key
     * 
     * @return boolean
     */
    public function valid()
    {
        return ($this->currentIndex < $this->count);
    }

    
    /**
     * Inits the iterator
     * 
     * @param       bool                $force
     * @return      CollectionIterator
     */
    protected function init($force = false)
    {
        return ($force || $this->count === null) ? $this->doInit() : $this;
        
    }
    
    
    protected function shouldLoadNext()
    {
        return $this->loadedIndex === count($this->loaded);
    }
    
    
    protected function loadNext()
    {
        $page = ++$this->currentPage;
        $this->loaded = $this->load($page);
    }
    
    
    protected function doInit()
    {
        $this->count = $this->dataProvider->getTotal();
        $this->pagesCount = $this->calculatePagesCount($this->perPage, $this->count);
        $this->currentIndex = 0;
        $this->currentPage = 1;
        
        if ($this->count > 0) {
            $this->loaded = $this->load($this->currentPage);
        } else {
            $this->loaded = [];
        }
        
        return $this;
    }
        
    
    protected function calculatePagesCount($perPage, $count)
    {
        if ($count === 0) {
            return 0;
        }
        if ($count <= $perPage) {
            return 1;
        }
        
        $mod = $count % $perPage;
        $pagesCount = $count / ($count - $mod);
        
        return ($mod > 0) ? ($pagesCount + 1) : $pagesCount;
    }
    
    
    protected function load($page)
    {                
        $this->loadedIndex = 0;
        return $this
                    ->dataProvider
                    ->getChunk(
                            $this->getOffset($page, $this->perPage), 
                            $this->perPage
                    );
    }
    
    
    protected function getOffset($page, $perPage)
    {
        return ($page - 1) * $perPage;
    }
    
    
    /**
     * Returns the number of  stored elements
     * 
     * @return      int
     */
    public function count()
    {
        return $this->init()->count;
    }
}