<?php
/**
 * User:    2131083
 * Date:    16.03.2016
 * Time:    21.26
 */

namespace AssignmentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Used for testing and cache-warmp after new functionality has been deployed,
 * or simply to keep cache warm.
 */
class CacheWarmerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('page:cache_warmup');
    }

    /**
     * Fetches data from the various sources and persists it to the configured cache-engine.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('varnish.domain_data_fetcher')->refreshCache();
        $this->getContainer()->get('varnish.file_data_fetcher')->refreshCache();
        $this->getContainer()->get('article.rss_data_fetcher')->refreshCache();
        $this->getContainer()->get('json_data_fetcher')->refreshCache();
    }
}