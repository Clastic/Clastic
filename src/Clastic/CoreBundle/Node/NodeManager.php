<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CoreBundle\Node;

use Clastic\CoreBundle\Event\NodeCreateEntityEvent;
use Clastic\CoreBundle\Event\NodeResolveEntityNameEvent;
use Clastic\CoreBundle\NodeEvents;
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
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    /**
     * @param string $type
     *
     * @return NodeReferenceInterface
     */
    public function createEntity($type)
    {
        $event = new NodeCreateEntityEvent($type);

        $this->dispatcher
            ->dispatch(NodeEvents::CREATE_ENTITY, $event);

        return $event->getEntity();
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
