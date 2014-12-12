<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Controller;

use Clastic\BackofficeBundle\Form\NodeDeleteType;
use Clastic\CoreBundle\Entity\Node;
use Clastic\BackofficeBundle\Form\NodeType;
use Clastic\CoreBundle\Module\ModuleManager;
use Clastic\TextBundle\Entity\Text;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * NodeController
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeController extends Controller
{
    public function listAction($type)
    {
        $queryBuilder = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('e')
            ->from($this->getEntityName($type), 'e')
            ->orderBy('e.id', 'DESC')
        ;

        $adapter = new DoctrineORMAdapter($queryBuilder);
        $data = new Pagerfanta($adapter);

        return $this->render('ClasticBackofficeBundle:Node:list.html.twig', array(
            'data' => $data,
            'type' => $type,
        ));
    }

    public function formAction($type, $nodeId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (!is_null($nodeId)) {
            $data = $this->getRepository($type)->find($nodeId);
        } else {
            $data = new Text();

            if (!$data->getNode()) {
                $node = new Node();
                $node->setType($type);
                $node->setUserId(1);
                $node->setCreated(new \DateTime());

                $data->setNode($node);
            }
        }

        $form = $this->createForm(new NodeType(), $data);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $node = $data->getNode();

            $node->setChanged(new \DateTime());

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

    public function deleteAction($type, $nodeId)
    {
        $data = $this->getRepository($type)->find($nodeId);

        $em = $this->getDoctrine()->getManager();

        $em->remove($data);
        $em->flush();

        return $this->redirect($this->generateUrl('clastic_backoffice_list', array(
            'type' => $type,
        )));
    }

    /**
     * @param string $type
     * @return EntityRepository
     */
    private function getRepository($type)
    {
        return $this->getDoctrine()->getManager()
            ->getRepository($this->getEntityName($type));
    }

    /**
     * @param string $type
     * @return string
     */
    private function getEntityName($type)
    {
        return 'ClasticTextBundle:Text';
    }

    /**
     * @return ModuleManager
     */
    private function getModuleManager()
    {
        return $this->get('clastic.module_manager');
    }
}
