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
     *
     * @param string $selector
     */
    public function theShouldBeSortedDescending($selector)
    {
        $container = $this->getSession()->getPage();
        $nodes = $container->findAll('css', $selector);
        $previous = $this->getNodeNumeric(array_shift($nodes));
        /** @var NodeElement $node */
        foreach ($nodes as $node) {
            $current = $this->getNodeNumeric($node);
            $this->assert($current < $previous, 'List is not sorted in descending order.');
        }
    }

    protected function getNodeNumeric(NodeElement $nodeElement)
    {
        $parts = explode(': ', $nodeElement->getText());

        $wrongFormatMessage = 'Text in element has wrong format.';
        $this->assert(count($parts) == 2, $wrongFormatMessage);
        $this->assert(is_numeric($parts[1]), $wrongFormatMessage);

        return $parts[1];
    }

    protected function assert($condition, $message)
    {
        $driver = $this->getMink()->getSession()->getDriver();
        if (!$condition) {
            throw new ExpectationException($message, $driver);
        }

    }
}
