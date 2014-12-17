<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CoreBundle\Event;

use Clastic\CoreBundle\Entity\Node;
use Clastic\CoreBundle\Node\NodeReferenceInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeCreateEvent extends Event
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var NodeReferenceInterface
     */
    private $entity;

    /**
     * @var Node
     */
    private $node;

    /**
     * @param string $type
     * @param Node   $node
     */
    public function __construct($type, Node $node)
    {
        $this->type = $type;
        $this->node = $node;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return NodeReferenceInterface
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param NodeReferenceInterface $entity
     */
    public function setEntity(NodeReferenceInterface $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return Node
     */
    public function getNode()
    {
        return $this->node;
    }
}
