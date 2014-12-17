<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Controller;

use Clastic\CoreBundle\Entity\Node;
use Clastic\CoreBundle\Node\NodeManager;
use Clastic\CoreBundle\Node\NodeReferenceInterface;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * NodeController
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeController extends Controller
{
    /**
     * @param string $type
     *
     * @return Response
     */
    public function listAction($type)
    {
        $queryBuilder = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('e')
            ->from($this->getNodeManager()->getEntityName($type), 'e')
            ->orderBy('e.id', 'DESC');

        $adapter = new DoctrineORMAdapter($queryBuilder);
        $data = new Pagerfanta($adapter);

        return $this->render('ClasticBackofficeBundle:Node:list.html.twig', array(
            'data' => $data,
            'type' => $type,
        ));
    }

    /**
     * @param string   $type
     * @param int|null $nodeId
     * @param Request  $request
     *
     * @return RedirectResponse|Response
     */
    public function formAction($type, $nodeId, Request $request)
    {
        $data = $this->resolveData($type, $nodeId);
        $form = $this->createForm('clastic_node', $data);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $this->persistData($data);

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Your changes were saved!');

            return $this->redirect($this->generateUrl('clastic_backoffice_form', array(
                 'type' => $type,
                 'nodeId' => $data->getNode()->getId(),
            )));
        }

        return $this->render('ClasticBackofficeBundle:Node:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param string $type
     * @param int    $nodeId
     *
     * @return RedirectResponse
     */
    public function deleteAction($type, $nodeId)
    {
        $data = $this->lookupData($type, $nodeId);

        $em = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();

        return $this->redirect($this->generateUrl('clastic_backoffice_list', array(
            'type' => $type,
        )));
    }

    /**
     * @param string $type
     * @param int    $nodeId
     *
     * @return NodeReferenceInterface
     */
    private function resolveData($type, $nodeId)
    {
        if (!is_null($nodeId)) {
            return $this->lookupData($type, $nodeId);
        }

        $data = $this->getNodeManager()->createNode($type);

        return $data;
    }

    /**
     * @param NodeReferenceInterface $data
     */
    private function persistData(NodeReferenceInterface $data)
    {
        $node = $data->getNode();

        $node->setChanged(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
    }

    /**
     * @param string $type
     * @param int    $nodeId
     *
     * @return NodeReferenceInterface
     */
    private function lookupData($type, $nodeId)
    {
        return $this->getRepository($type)->find($nodeId);
    }

    /**
     * @param string $type
     *
     * @return EntityRepository
     */
    private function getRepository($type)
    {
        return $this->getDoctrine()->getManager()
            ->getRepository($this->getNodeManager()->getEntityName($type));
    }

    /**
     * @return NodeManager
     */
    private function getNodeManager()
    {
        return $this->get('clastic.node_manager');
    }
}
