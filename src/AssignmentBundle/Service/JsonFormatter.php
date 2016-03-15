<?php
/**
 * User:    2131083
 * Date:    15.03.2016
 * Time:    19.10
 */

namespace AssignmentBundle\Service;

use AssignmentBundle\Interfaces\Formatter;
use AssignmentBundle\Model\Item;

class JsonFormatter implements Formatter
{
    /**
     * @param $dataString
     *
     * @return Item[]
     */
    public function format($dataString)
    {
        $jsonItems = json_decode($dataString, true);

        $items = [];
        foreach ($jsonItems as $item) {
            if (!isset($item['title'])) {
                continue;
            }

            $timestamp = $this->itemStringToTime($item);
            if (!$timestamp) {
                continue;
            }

            $items[] = new Item($item['title'], $timestamp);
        }

        return $items;
    }

    protected function itemStringToTime($item)
    {
        if (!isset($item['date']) || !isset($item['time'])) {
            return false;
        }

        /**
         * Note:
         *
         * strptime is not implemented on the Windows-platform.
         * There are some cumbersome options available like the intl-extension,
         * but lets be pragmatic for now.
         */
        setlocale(LC_TIME, 'no_NO');
        $dateArray = strptime($item['date'] . ' ' . $item['time'], '%e %B %Y %H:%M');
        if (!$dateArray) {
            return false;
        }

        return mktime(
            $dateArray['tm_hour'],
            $dateArray['tm_min'],
            0, // Seconds are not provided, nor parsed.
            $dateArray['tm_mon'],
            $dateArray['tm_mday'],
            $dateArray['tm_year'] + 1900 // Yup! That's how it is done.
        );
    }
}