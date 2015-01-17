<?php

namespace Demo\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    public function indexAction()
    {
        $blogPosts = $this->getDoctrine()
            ->getRepository('ClasticBlogBundle:Blog')
            ->findBy(array(), array('id' => 'DESC'), 5);

        return $this->render('DemoBundle:Homepage:index.html.twig', array(
            'blogPosts' => $blogPosts,
        ));
    }
}
