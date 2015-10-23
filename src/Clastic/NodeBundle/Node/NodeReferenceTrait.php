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

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
trait NodeReferenceTrait
{
    /**
     * @var Node
     */
    private $node;

    /**
     * @return Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @param Node $node
     */
    public function setNode(Node $node)
    {
        $this->node = $node;
    }
}
