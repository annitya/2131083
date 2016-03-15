<?php
/**
 * User:    213
 * Date:    15.03.2016
 * Time:    16.42
 */

namespace AssignmentBundle\Service;

use AssignmentBundle\Interfaces\Formatter;

class DataFetcher
{
    /** @var string */
    protected $sourceUrl;
    /** @var Formatter */
    protected $formatter;

    public function __construct($sourceUrl, Formatter $formatter)
    {
        $this->sourceUrl = $sourceUrl;
        $this->formatter = $formatter;
    }

    public function getFormattedData()
    {
        // @TODO: Add exception handling.
        $data = file_get_contents($this->sourceUrl);
        return $this->formatter->format($data);
    }
}

