<?php
/**
 * User:    2131083
 * Date:    15.03.2016
 * Time:    21.57
 */

namespace AssignmentBundle\Interfaces;

use AssignmentBundle\Model\Item;

/**
 * Contract for services which are used to sort Items created by a formatter.
 */
interface ItemSorter
{
    /**
     * @param Item[] $items
     *
     * @return Item[]
     */
    public function sort($items);

    /**
     * @param Item $a
     * @param Item $b
     *
     * @return \AssignmentBundle\Model\Item[]
     */
    function compare(Item $a, Item $b);
}