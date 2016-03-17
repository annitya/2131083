<?php

namespace AssignmentBundle\Controller;

use AssignmentBundle\Model\ItemResponse;
use AssignmentBundle\Service\DataFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ViewController extends Controller
{
    /**
     * Renders homepage.
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('AssignmentBundle::pagelayout.html.twig');
    }

    /**
     * Top 5 most visited hosts.
     *
     * @return Response
     */
    public function varnishDomainsAction()
    {
        $title = 'The top 5 most visited hosts';
        $itemResponse = $this->fetchData($this->container->get('varnish.domain_data_fetcher'));

        return $this->render('AssignmentBundle:parts:tab.html.twig', compact('itemResponse', 'title'));
    }

    /**
     * Top 5 most downloaded files.
     *
     * @return Response
     */
    public function varnishFilesAction()
    {
        $title = 'The top 5 most downloaded files';
        $itemResponse = $this->fetchData($this->container->get('varnish.file_data_fetcher'));

        return $this->render('AssignmentBundle:parts:tab.html.twig', compact('itemResponse', 'title'));
    }

    /**
     * Renders sorted articles from the RSS-feed.
     *
     * @return Response
     */
    public function rssFeedAction()
    {
        $title = 'RSS-feed';
        $itemResponse = $this->fetchData($this->container->get('article.rss_data_fetcher'));

        return $this->render('AssignmentBundle:parts:tab.html.twig', compact('itemResponse', 'title'));
    }

    /**
     * Renders articles from the JSON-feed.
     *
     * @return Response
     */
    public function jsonArticlesAction()
    {
        $title = 'JSON-articles';
        $itemResponse = $this->fetchData($this->container->get('json_data_fetcher'));

        return $this->render('AssignmentBundle:parts:tab.html.twig', compact('itemResponse', 'title'));
    }

    /**
     * Overridden method to add cache-settings to response.
     *
     * @param string $view
     * @param array $parameters
     * @param Response|null $response
     *
     * @return Response
     */
    protected function render($view, array $parameters = [], Response $response = null)
    {
        $response = $response ?: new Response();
        $response->setSharedMaxAge($this->container->getParameter('default_ttl'));

        return parent::render($view, $parameters, $response);
    }

    /**
     * Constructs an item-response from the result returned by the provided data-fetcher.
     * Also makes sure exceptions are handled gracefully.
     *
     * @param DataFetcher $dataFetcher
     *
     * @return ItemResponse
     */
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
