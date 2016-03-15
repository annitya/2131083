<?php
/**
 * User:    2131083
 * Date:    15.03.2016
 * Time:    16.47
 */

namespace AssignmentBundle\Model;

class Item
{
    /** @var string */
    protected $description;
    /** @var mixed */
    protected $sortValue;

    public function __construct($description, $sortValue)
    {
        $this->description = $description;
        $this->sortValue = $sortValue;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getSortValue()
    {
        return $this->sortValue;
    }
}