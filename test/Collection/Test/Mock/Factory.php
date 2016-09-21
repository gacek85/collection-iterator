<?php
namespace Gacek85\Collection\Test\Mock;

use Faker\Factory as FakerFactory;

/**
 *  Factory for the mock and array
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
final class Factory 
{
    /**
     * Returns the mock
     * 
     * @param       int         $length
     * @return      array       An array containing the original array of data on
     *                          index 0 and the mock iterator on index 1
     */
    public static function getMock($length)
    {
        $faker = FakerFactory::create();
        $results = [];
        for ($i = 0; $i < $length; $i++) {
            $results[] = $faker->word;
        }
        
        return [
            $results,
            new IterableDataProviderMock($results)
        ];
    }
}