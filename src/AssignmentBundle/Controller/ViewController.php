<?php

namespace AssignmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewController extends Controller
{
    public function indexAction()
    {
        $varnishItems = $this->container->get('varnish.data_fetcher')->getFormattedData();
        return $this->render('AssignmentBundle::pagelayout.html.twig', compact('varnishItems'));
    }
}
