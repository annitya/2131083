<?php
/**
 * User:    2131083
 * Date:    15.03.2016
 * Time:    18.55
 */

namespace AssignmentBundle\Service;

use AssignmentBundle\Interfaces\Formatter;
use AssignmentBundle\Model\Item;

class ArticleFormatter implements Formatter
{
    /**
     * @param $dataString
     *
     * @return Item[]
     */
    public function format($dataString)
    {
        $simpleXml = simplexml_load_string($dataString);
        if (!$simpleXml) {
            return [];
        }

        if (!isset($simpleXml->channel->item) || ! $simpleXml->channel->item->count()) {
            return [];
        }

        $articleItems = [];
        foreach ($simpleXml->channel->item as $item) {
            if (!isset($item->pubDate)) {
                continue;
            }

            // Not much of an article without a title.
            if (!isset($item->title)) {
                continue;
            }

            $timestamp = strtotime($item->pubDate);
            if (!$timestamp) {
                continue;
            }

            $articleItems[] = new Item($item->title, $timestamp);
        }

        uasort($articleItems, ['AssignmentBundle\Model\Item', 'compare']);
        return $articleItems;
    }
}