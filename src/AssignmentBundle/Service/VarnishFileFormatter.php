<?php
/**
 * User:    2131083
 * Date:    15.03.2016
 * Time:    18.22
 */

namespace AssignmentBundle\Service;

/**
 * Retrieves files from varnish-log.
 */
class VarnishFileFormatter extends VarnishDomainFormatter
{
    protected function getLineValue($line)
    {
        $logValues = $this->logParser->parse($line);
        if (!isset($logValues->request)) {
            return false;
        }

        $requestParts = explode(' ', $logValues->request);
        if (!isset($requestParts[1])) {
            return false;
        }

        $urlParts = parse_url($requestParts[1]);

        if (!isset($urlParts['host']) || !isset($urlParts['path'])) {
            return false;
        }

        $pathInfo = pathinfo($urlParts['path']);
        if (!isset($pathInfo['extension']) || $pathInfo['extension'] == 'php') {
            return false;
        }

        /**
         * @TODO: Better handling of static files.
         *
         * Files with identical names provided by the different static servers are very likely the same.
         * Many of the files in the varnish-log lacks size, so a comparison is impractical.
         * I consider this edge-case out of scope for now, but it is definitely something I would fix IRL.
         */
        return $urlParts['host'] . $urlParts['path'];
    }
}