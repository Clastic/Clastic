<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Controller;

use Clastic\CoreBundle\Node\NodeManager;
use Clastic\CoreBundle\Node\NodeReferenceInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * NodeController
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeController extends AbstractModuleController
{
    /**
     * @var string
     */
    private $type;

    /**
     * @return string
     */
    protected function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    protected function getListTemplate()
    {
        return 'ClasticBackofficeBundle:Node:list.html.twig';
    }

    /**
     * @param object $data
     *
     * @return Form
     */
    protected function buildForm($data)
    {
        return $this->createForm('clastic_node', $data);
    }

    /**
     * @param object $data
     *
     * @return string
     */
    protected function resolveDataTitle($data)
    {
        if (!$data->getId()) {
            return 'New';
        }

        return $data->getNode()->getTitle();
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return $this->getNodeManager()->getEntityName($this->getType());
    }

    /**
     * @param string $type
     *
     * @return Response
     */
    public function listAction($type = null)
    {
        $this->type = $type;

        return parent::listAction();
    }

    /**
     * @param int|null $id
     * @param Request  $request
     * @param string   $type
     *
     * @return RedirectResponse|Response
     */
    public function formAction($id, Request $request, $type = null)
    {
        $this->type = $type;

        return parent::formAction($id, $request);
    }

    /**
     * @param int     $id
     * @param Request $request
     * @param string  $type
     *
     * @return RedirectResponse
     */
    public function deleteAction($id, Request $request, $type = null)
    {
        $this->type = $type;

        return parent::deleteAction($id, $request);
    }

    /**
     * @param int $id
     *
     * @return NodeReferenceInterface
     */
    protected function resolveData($id)
    {
        if (!is_null($id)) {
            return $this->getNodeManager()->loadNode($id, $this->getType());
        }

        $data = $this->getNodeManager()->createNode($this->getType());

        $data->getNode()->setUser($this->get('security.context')->getToken()->getUser());

        return $data;
    }

    /**
     * @param NodeReferenceInterface $data
     */
    protected function persistData($data)
    {
        $node = $data->getNode();
        $node->setChanged(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
    }

    /**
     * @return NodeManager
     */
    private function getNodeManager()
    {
        return $this->get('clastic.node_manager');
    }
}
