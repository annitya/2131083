<?php

namespace AssignmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewController extends Controller
{
    public function indexAction()
    {
        $varnishDomains = $this->container->get('varnish.domain_data_fetcher')->getFormattedData();
        $varnishFiles = $this->container->get('varnish.file_data_fetcher')->getFormattedData();
        $articles = $this->container->get('article.rss_data_fetcher')->getFormattedData();

        return $this->render('AssignmentBundle::pagelayout.html.twig', compact('varnishDomains', 'varnishFiles', 'articles'));
    }
}
