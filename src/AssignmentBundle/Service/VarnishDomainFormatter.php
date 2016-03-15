<?php
/**
 * User:    2131083
 * Date:    15.03.2016
 * Time:    16.52
 */

namespace AssignmentBundle\Service;

use AssignmentBundle\Interfaces\Formatter;
use AssignmentBundle\Model\Item;
use Kassner\LogParser\LogParser;

class VarnishDomainFormatter implements Formatter
{
    /** @var LogParser */
    protected $logParser;
    /** @var int */
    protected $limit;

    public function __construct(LogParser $logParser, $limit)
    {
        $this->logParser = $logParser;
        $this->limit = $limit;
    }

    /**
     * @inheritdoc
     */
    public function format($dataString)
    {
        $lines = explode("\n", $dataString);
        // No empty lines please.
        $lines = array_filter($lines);
        $entries = array_map([$this, 'getLineValue'], $lines);
        // Remove invalid and empty entries.
        $entries = array_filter($entries);
        $countValues = array_count_values($entries);

        $items = [];
        foreach ($countValues as $domain => $count) {
            $items[] = new Item($domain . ': ' . $count, $count);
        }

        uasort($items, ['AssignmentBundle\Model\Item', 'compare']);
        return array_slice($items, 0, $this->limit);
    }

    protected function getLineValue($line)
    {
        $logValues = $this->logParser->parse($line);
        if (!isset($logValues->HeaderReferer)) {
            return false;
        }
        $urlParts = parse_url($logValues->HeaderReferer);
        // Fallback to request-parsing if HeaderReferer is of no help.
        if (!isset($urlParts['host']) && !isset($logValues->request)) {
            $requestParts = explode(' ', $logValues->request);
            $urlParts = parse_url($requestParts[1]);
        }

        return isset($urlParts['host']) ? $urlParts['host'] : '';
    }
}