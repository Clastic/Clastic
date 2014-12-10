<?php

namespace Clastic\BackofficeBundle\Controller;

use Clastic\CoreBundle\Entity\Node;
use Clastic\CoreBundle\Module\ModuleManager;
use Clastic\TextBundle\Entity\Text;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NodeController extends Controller
{
    public function listAction($type)
    {
//        $data = new Text();
//
//        $form = $this->createFormBuilder($data)
//          ->add('title')
//          ->add('save', 'submit', array('label' => 'Create Task'))
//          ->getForm();

        return $this->render('ClasticBackofficeBundle:Node:list.html.twig', array(
//            'form' => $form,
        ));
    }

    public function formAction($type, $node_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (!is_null($node_id)) {
            $data = $em->getRepository('ClasticTextBundle:Text')->find($node_id);
        } else {
            $data = new Text();

            if (!$data->getNode()) {
                $data->setNode(new Node());
                $data->getNode()
                  ->setCreated(new \DateTime());
            }
        }


        $form = $this->createFormBuilder($data)
          ->add('title', 'text', array(
                'property_path' => 'node.title'
            ))
          ->add('body')
          ->add('save', 'submit', array('label' => 'Save'))
          ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $data->getNode()
              ->setTitle($form->get('title')->getViewData());

            $data->getNode()
              ->setChanged(new \DateTime());
            $data->getNode()
              ->setType($type);
            $data->getNode()
              ->setUserId(1);

            $em->persist($data);
            $em->flush();

            return $this->redirect($this->generateUrl('clastic_backoffice_form', array(
                 'type' => $type,
                 'node_id' => $data->getNode()->getId(),
            )));
        }


        return $this->render('ClasticBackofficeBundle:Node:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @return ModuleManager
     */
    private function getModuleManager()
    {
        return $this->get('clastic.module_manager');
    }
}
