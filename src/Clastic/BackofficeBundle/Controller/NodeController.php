<?php

namespace Clastic\BackofficeBundle\Controller;

use Clastic\CoreBundle\Entity\Node;
use Clastic\BackofficeBundle\Form\NodeType;
use Clastic\CoreBundle\Module\ModuleManager;
use Clastic\TextBundle\Entity\Text;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NodeController extends Controller
{
    public function listAction($type)
    {
        $queryBuilder = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('e')
            ->from('ClasticTextBundle:Text', 'e')
            ;

        $adapter = new DoctrineORMAdapter($queryBuilder);
        $data = new Pagerfanta($adapter);

        return $this->render('ClasticBackofficeBundle:Node:list.html.twig', array(
            'data' => $data,
            'type' => $type,
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

        $form = $this->createForm(new NodeType(), $data);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $node = $data->getNode();

            $node->setChanged(new \DateTime());
            $node->setType($type);
            $node->setUserId(1);

            $em->persist($data);
            $em->flush();

            $request->getSession()->getFlashBag()->add(
                'success',
                'Your changes were saved!'
            );

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
