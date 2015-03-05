<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NodeBundle\Tests\Stubs;

use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Clastic\NodeBundle\Node\NodeReferenceTrait;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeReferenceEntity implements NodeReferenceInterface
{
    use NodeReferenceTrait;
}
