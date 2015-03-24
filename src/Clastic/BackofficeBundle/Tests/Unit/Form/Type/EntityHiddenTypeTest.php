<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Tests\Unit\Form\Type;

use Clastic\BackofficeBundle\Form\Type\EntityHiddenType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group functional
 */
class EntityHiddenTypeTest extends TypeTestCase
{
    public function testParent()
    {
        $objectManager = $this->getMockBuilder('Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();

        $type = new EntityHiddenType($objectManager);

        $this->assertEquals('hidden', $type->getParent());
    }
}
