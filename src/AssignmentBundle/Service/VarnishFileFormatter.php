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

        // @TODO: Possible pitfall: Content served from static servers may actually be the same file.
        // @TODO: Consider custom hash to determine uniqueness of file.
        return $urlParts['host'] . $urlParts['path'];
    }

}