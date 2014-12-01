<?php

namespace Clastic\BackofficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClasticBackofficeBundle:Dashboard:index.html.twig');
    }
}
