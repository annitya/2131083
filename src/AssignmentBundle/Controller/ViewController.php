<?php

namespace AssignmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewController extends Controller
{
    public function indexAction()
    {
        return $this->render('AssignmentBundle:Default:index.html.twig');
    }
}
