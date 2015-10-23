<?php

namespace Demo\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    public function indexAction()
    {
        return $this->render('DemoBundle:Homepage:index.html.twig', array(
            'blogPosts' => [],
        ));
    }
}
