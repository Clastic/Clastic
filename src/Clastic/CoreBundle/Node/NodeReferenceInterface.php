<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CoreBundle\Node;

use Clastic\CoreBundle\Entity\Node;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
interface NodeReferenceInterface
{
    /**
     * @return Node
     */
    public function getNode();

    /**
     * @param Node $node
     */
    public function setNode(Node $node);
}
