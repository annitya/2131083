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
     * @param $selector
     */
    public function theArticlesInShouldBeSorted($selector)
    {
        $this->assertNodesAreSorted($selector, [$this, 'getRssArticleTimestamp']);
    }

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
     * @Given /^I wait (\d+) microseconds for the animation$/
     * @param $microSeconds
     */
    public function iWaitMicrosecondsForTheAnimation($microSeconds)
    {
        usleep($microSeconds);
    }

    protected function getVarnishVisitedCount(NodeElement $nodeElement)
    {
        $parts = explode(': ', $nodeElement->getText());

        $wrongFormatMessage = 'Text in element has wrong format.';
        $this->assert(count($parts) == 2, $wrongFormatMessage);
        $this->assert(is_numeric($parts[1]), $wrongFormatMessage);

        return $parts[1];
    }

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

    protected function assert($condition, $message)
    {
        $driver = $this->getMink()->getSession()->getDriver();
        if (!$condition) {
            throw new ExpectationException($message, $driver);
        }

    }
}
