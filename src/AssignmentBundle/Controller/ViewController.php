<?php

namespace AssignmentBundle\Controller;

use AssignmentBundle\Model\ItemResponse;
use AssignmentBundle\Service\DataFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewController extends Controller
{
    public function indexAction()
    {
        return $this->render('AssignmentBundle::pagelayout.html.twig');
    }

    public function varnishDomainsAction()
    {
        $title = 'The top 5 most visited hosts';
        $itemResponse = $this->fetchData($this->container->get('varnish.domain_data_fetcher'));

        return $this->render('AssignmentBundle:parts:tab.html.twig', compact('itemResponse', 'title'));
    }

    public function varnishFilesAction()
    {
        $title = 'The top 5 most downloaded files';
        $itemResponse = $this->fetchData($this->container->get('varnish.file_data_fetcher'));

        return $this->render('AssignmentBundle:parts:tab.html.twig', compact('itemResponse', 'title'));
    }

    public function rssFeedAction()
    {
        $title = 'RSS-feed';
        $itemResponse = $this->fetchData($this->container->get('article.rss_data_fetcher'));

        return $this->render('AssignmentBundle:parts:tab.html.twig', compact('itemResponse', 'title'));
    }

    public function jsonArticlesAction()
    {
        $title = 'JSON-articles';
        $itemResponse = $this->fetchData($this->container->get('json_data_fetcher'));

        return $this->render('AssignmentBundle:parts:tab.html.twig', compact('itemResponse', 'title'));
    }

    protected function fetchData(DataFetcher $dataFetcher)
    {
        $itemResponse = new ItemResponse();
        try {
            $itemResponse->items = $dataFetcher->getFormattedData();
        }
        catch (\Exception $e) {
            $itemResponse->error = 'Unable to fetch data.';
        }

        return $itemResponse;
    }
}
