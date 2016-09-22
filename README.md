[![Build Status](https://travis-ci.org/gacek85/collection-iterator.svg?branch=master)](https://travis-ci.org/gacek85/collection-iterator)

#Collection Iterator

An implementation of `SPL's` `Iterator` for traversing large collections of data minimising the risk of memory limit exhaustion. Consists of an iterator service class `Gacek85\Collection\CollectionIterator` and an interface `Gacek85\Collection\IterableDataProvider` for a provider that will be providing chunks of data to the iterator service.

##How it works

The iterator loads the data using the provider **chunk by chunk**, previously loaded data are wiped out of the memory by the garbage collector.

##Public API

###CollectionIterator

``` php
setPerPage(int $perPage): CollectionIterator // Sets the number of items loaded at once
count(): int	// Returns the total count of the elements that will be traversed
```

Other public methods are `Iterator` specific API.

###IterableDataProvider

``` php
getTotal(): int // Returns the total count of available elements
getChunk(int $offset, int $limit): array|Iterator //Returns the chunk of data from given offset limited with given limit
```


##Usage

``` php
<?php

$provider = new \My\Provider(); // An implementation of Gacek85\Collection\IterableDataProvider
$iterator = new \Gacek85\Collection\CollectionIterator($provider);

foreach ($iterator as $k => $item) {
	// Do your stuff here with the item
}
```