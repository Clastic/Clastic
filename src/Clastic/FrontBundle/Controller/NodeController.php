<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\FrontBundle\Controller;

use Clastic\FrontBundle\Event\FrontNodeEvent;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class NodeController
 */
class NodeController extends Controller
{
    /**
     * @param int $id
     *
     * @return Response
     */
    public function detailAction($id)
    {
        $record = $this->findNode($id);

        return $this->renderTemplate($record);
    }

    /**
     * @param int $id
     *
     * @return NodeReferenceInterface
     */
    private function findNode($id)
    {
        $node = $this->get('clastic.node_manager')
            ->loadNode($id);

        if (!$node) {
            throw new NotFoundHttpException();
        }

        return $node;
    }

    /**
     * @param NodeReferenceInterface $record
     *
     * @return Response
     */
    private function renderTemplate(NodeReferenceInterface $record)
    {
        $event = new FrontNodeEvent(
            $record->getNode(),
            'ClasticFrontBundle:Node:detail.html.twig',
            array('record' => $record)
        );
        $this->get('event_dispatcher')
            ->dispatch('clastic.node.front', $event);

        return $this->render($event->getTemplate(), $event->getTemplateArguments());
    }
}
