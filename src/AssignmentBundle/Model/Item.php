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
    protected $sortField;

    public function __construct($description, $sortField)
    {
        $this->description = $description;
        $this->sortField = $sortField;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    public static function compare(Item $a, Item $b)
    {
        if ($a->sortField == $b->sortField) {
            return 0;
        }

        return $a->sortField > $b->sortField ? -1 : 1;
    }
}