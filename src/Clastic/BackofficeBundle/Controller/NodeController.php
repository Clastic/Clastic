<?php

namespace Clastic\BackofficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NodeController extends Controller
{
    public function listAction()
    {
        return $this->render('ClasticBackofficeBundle:Node:list.html.twig');
    }

    public function formAction()
    {
        return $this->render('ClasticBackofficeBundle:Node:form.html.twig');
    }
}
