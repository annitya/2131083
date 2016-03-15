<?php
/**
 * User:    2131083
 * Date:    15.03.2016
 * Time:    16.52
 */

namespace AssignmentBundle\Model;

use AssignmentBundle\Interfaces\Formatter;
use Kassner\LogParser\LogParser;

class VarnishFormatter implements Formatter
{
    /** @var LogParser */
    protected $logParser;

    public function __construct(LogParser $logParser)
    {
        $this->logParser = $logParser;
    }

    /**
     * @inheritdoc
     */
    public function format($dataString)
    {
        $lines = explode("\n", $dataString);
        // No empty lines please.
        $lines = array_filter($lines);
        $domainEntries = array_map([$this, 'extractDomain'], $lines);
        // Remove invalid and empty entries.
        $domainEntries = array_filter($domainEntries);
        $countValues = array_count_values($domainEntries);

        $items = [];
        foreach ($countValues as $domain => $count) {
            $items[] = new Item($domain . ': ' . $count, $count);
        }

        return $items;
    }

    protected function extractDomain($line)
    {
        $logValues = $this->logParser->parse($line);
        $urlParts = parse_url($logValues->HeaderReferer);
        // Fallback to request-parsing if HeaderReferer is of no help.
        if (!isset($urlParts['host'])) {
            $requestParts = explode(' ', $logValues->request);
            $urlParts = parse_url($requestParts[1]);
        }

        return isset($urlParts['host']) ? $urlParts['host'] : '';
    }
}