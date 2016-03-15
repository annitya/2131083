<?php
/**
 * User:    2131083
 * Date:    15.03.2016
 * Time:    16.47
 */

namespace AssignmentBundle\Model;

class Item
{
    protected $description;

    public function __construct($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}