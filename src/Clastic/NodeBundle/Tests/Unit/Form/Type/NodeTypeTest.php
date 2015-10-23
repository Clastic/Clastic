<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\NodeBundle\Tests\Unit\Form\Type;

use Clastic\NodeBundle\Form\Type\NodeType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group unit
 */
class NodeTypeTest extends TypeTestCase
{
    public function testParent()
    {
        $type = new NodeType();

        $this->assertEquals('entity', $type->getParent());
    }
}
