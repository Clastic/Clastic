<?php

namespace Clastic\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($name, Request $request)
    {
        return $this->render('ClasticCoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
