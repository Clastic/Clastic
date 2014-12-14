<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CoreBundle\Event;

use Clastic\CoreBundle\Node\NodeReferenceInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeCreateEntityEvent extends Event
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
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
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
}
