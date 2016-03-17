<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ExpectationException;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct() {}

    /**
     * @Given /^the "(.*)" should be sorted descending$/
     * @param string $selector
     */
    public function theShouldBeSortedDescending($selector)
    {
        $this->assertNodesAreSorted($selector, [$this, 'getVarnishVisitedCount']);
    }

    /**
     * @Given /^the articles in "([^"]*)" should be sorted$/
     * @param string $selector
     */
    public function theArticlesInShouldBeSorted($selector)
    {
        $this->assertNodesAreSorted($selector, [$this, 'getRssArticleTimestamp']);
    }

    /**
     * Makes sure the provided DOM-nodes are sorted in descending order.
     *
     * @param string $selector
     * @param callable $nodeFormatter
     *
     * @throws ExpectationException
     */
    protected function assertNodesAreSorted($selector, $nodeFormatter)
    {
        $container = $this->getSession()->getPage();
        $nodes = $container->findAll('css', $selector);

        $previous = $nodeFormatter(array_shift($nodes));
        /** @var NodeElement $node */
        foreach ($nodes as $node) {
            $current = $nodeFormatter($node);
            $this->assert($current < $previous, 'List is not sorted in descending order.');
        }
    }

    /**
     * Helper method. Used to wait for browser-animations to finish.
     *
     * @Given /^I wait (\d+) microseconds for the animation$/
     *
     * @param $microSeconds
     */
    public function iWaitMicrosecondsForTheAnimation($microSeconds)
    {
        usleep($microSeconds);
    }

    /**
     * Extracts the visit-count from the text within the element.
     *
     * @param NodeElement $nodeElement
     *
     * @return mixed
     *
     * @throws ExpectationException
     */
    protected function getVarnishVisitedCount(NodeElement $nodeElement)
    {
        $parts = explode(' ', $nodeElement->getText());

        $wrongFormatMessage = 'Text in element has wrong format.';
        $this->assert(count($parts) > 1, $wrongFormatMessage);
        $this->assert(is_numeric($parts[1]), $wrongFormatMessage);

        return $parts[count($parts) - 1];
    }

    /**
     * Extracts timestamp from time-date string used by RSS-list.
     *
     * @param NodeElement $nodeElement
     *
     * @return int
     *
     * @throws ExpectationException
     */
    protected function getRssArticleTimestamp(NodeElement $nodeElement)
    {
        $parts = explode('(', $nodeElement->getText());
        $this->assert(count($parts) > 0, 'Article is missing date and/or time.');
        $timeString = trim($parts[count($parts) - 1], ')');
        $timeString = str_replace('- ', '', $timeString);

        $timestamp = strtotime($timeString);
        $this->assert(is_numeric($timestamp), 'Date/time is in wrong format');

        return $timestamp;
    }

    /**
     * Throws a testing-compliant exception if the condition is not evaluated as truthy.
     *
     * @param $condition
     * @param $message
     *
     * @throws ExpectationException
     */
    protected function assert($condition, $message)
    {
        $driver = $this->getMink()->getSession()->getDriver();
        if (!$condition) {
            throw new ExpectationException($message, $driver);
        }

    }
}
