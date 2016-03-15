<?php
/**
 * User:    2131083
 * Date:    15.03.2016
 * Time:    16.44
 */

namespace AssignmentBundle\Interfaces;

use AssignmentBundle\Model\Item;

interface Formatter
{
    /**
     * @param $dataString
     *
     * @return Item[]
     */
    public function format($dataString);
}