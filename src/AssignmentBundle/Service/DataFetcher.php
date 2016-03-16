<?php
/**
 * User:    213
 * Date:    15.03.2016
 * Time:    16.42
 */

namespace AssignmentBundle\Service;

use AssignmentBundle\Interfaces\Formatter;
use AssignmentBundle\Interfaces\ItemSorter;
use GuzzleHttp\Client;
use Tedivm\StashBundle\Service\CacheService;

class DataFetcher
{
    /** @var string */
    protected $sourceUrl;
    /** @var Formatter */
    protected $formatter;
    /** @var ItemSorter */
    protected $itemSorter;
    /** @var bool|int */
    protected $limit = false;
    /** @var CacheService */
    protected $cache;

    public function __construct($sourceUrl, Formatter $formatter, ItemSorter $itemSorter, CacheService $cache)
    {
        $this->sourceUrl = $sourceUrl;
        $this->formatter = $formatter;
        $this->itemSorter = $itemSorter;
        $this->cache = $cache;
    }

    public function getFormattedData()
    {
        $data = $this->fetchData();

        $items = $this->formatter->format($data);
        $items = $this->itemSorter->sort($items);
        if ($this->limit) {
            $items = array_slice($items, 0, $this->limit);
        }

        return $items;
    }

    protected function fetchData()
    {
        $key = md5($this->sourceUrl);
        $item = $this->cache->getItem($key);
        if ($item->isHit()) {
            return $item->get();
        }

        $client = new Client();
        $response = $client->request('GET', $this->sourceUrl);
        $data = $response->getBody()->getContents();
        if (!$data) {
            throw new \Exception('Got empty response from server.');
        }

        $item->set($data);
        $item->save();

        return $data;
    }

    /**
     * @param bool|int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }
}

