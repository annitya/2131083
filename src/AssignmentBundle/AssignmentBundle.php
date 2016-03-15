<?php

namespace AssignmentBundle;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AssignmentBundle extends Bundle
{
    public function indexAction()
    {
        return new Response('Hello world!');
    }
}
