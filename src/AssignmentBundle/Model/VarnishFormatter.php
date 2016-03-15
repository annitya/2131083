<?php
/**
 * User:    2131083
 * Date:    15.03.2016
 * Time:    16.52
 */

namespace AssignmentBundle\Model;

use AssignmentBundle\Interfaces\Formatter;

class VarnishFormatter implements Formatter
{
    /**
     * @inheritdoc
     */
    public function format($dataString)
    {
        return[new Item('Totally formatted')];
    }
}