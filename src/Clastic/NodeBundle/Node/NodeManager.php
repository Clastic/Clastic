<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NodeBundle\Node;

use Clastic\NodeBundle\Entity\Node;
use Clastic\NodeBundle\Entity\NodePublication;
use Clastic\NodeBundle\Event\NodeCreateEvent;
use Clastic\NodeBundle\Event\NodeResolveEntityNameEvent;
use Clastic\CoreBundle\NodeEvents;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * NodeManager
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeManager
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @param Registry                 $registry
     */
    public function __construct(EventDispatcherInterface $dispatcher, Registry $registry)
    {
        $this->dispatcher = $dispatcher;
        $this->registry = $registry;
    }

    /**
     * @param string $type
     *
     * @return NodeReferenceInterface
     * @throws \Exception
     */
    public function createNode($type)
    {
        $node = new Node();
        $node->setType($type);
        $node->setCreated(new \DateTime());

        $event = new NodeCreateEvent($type, $node);
        $event = $this->dispatcher
            ->dispatch(NodeEvents::CREATE, $event);

        $entity = $event->getEntity();
        if (!$entity) {
            throw new \Exception('Not found.');
        }

        $entity->setNode($event->getNode());
        $entity->getNode()->setPublication(new NodePublication());

        return $entity;
    }

    /**
     * @param int         $nodeId
     * @param null|string $type
     *
     * @return NodeReferenceInterface
     */
    public function loadNode($nodeId, $type = null)
    {
        if (is_null($type)) {
            $node = $this->registry->getRepository('ClasticNodeBundle:Node')
                ->find($nodeId);
            $type = $node->getType();
        }

        return $this->registry
            ->getRepository($this->getEntityName($type))
            ->findOneBy(array('node' => $nodeId));
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getEntityName($type)
    {
        $event = new NodeResolveEntityNameEvent($type);
        $this->dispatcher
            ->dispatch(NodeEvents::RESOLVE_ENTITY_NAME, $event);

        return $event->getEntityName();
    }
}
