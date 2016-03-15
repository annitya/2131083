<?php
/**
 * User:    2131083
 * Date:    15.03.2016
 * Time:    21.57
 */

namespace AssignmentBundle\Service;

use AssignmentBundle\Interfaces\ItemSorter;
use AssignmentBundle\Model\Item;

class DescendingItemSorter implements ItemSorter
{
    /**
     * @inheritdoc
     */
    public function sort($items)
    {
        uasort($items, ['AssignmentBundle\Service\DescendingItemSorter', 'compare']);
        return $items;
    }

    function compare(Item $a, Item $b)
    {
        if ($a->getSortValue() == $b->getSortValue()) {
            return 0;
        }

        return $a->getSortValue() > $b->getSortValue() ? -1 : 1;
    }
}