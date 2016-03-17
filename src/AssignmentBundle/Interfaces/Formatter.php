<?php
/**
 * User:    2131083
 * Date:    15.03.2016
 * Time:    16.44
 */

namespace AssignmentBundle\Interfaces;

use AssignmentBundle\Model\Item;

/**
 * All formatters applied to data retrieved via a DataFetcher must implement this interface.
 */
interface Formatter
{
    /**
     * @param $dataString
     *
     * @return Item[]
     */
    public function format($dataString);
}