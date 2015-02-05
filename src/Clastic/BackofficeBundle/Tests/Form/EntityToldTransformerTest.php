<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Tests\Form;

use Clastic\BackofficeBundle\Form\DataTransformer\EntityToIdTransformer;

/**
 * EntityToldTransformerTest
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class EntityToldTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test transforming entity to int.
     */
    public function testEntityToId()
    {
        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $transformer = new EntityToIdTransformer($objectManager, 'class');

        $entity = $this->getMockBuilder('stdClass')
            ->setMethods(array('getId'))
            ->getMock();

        $id = rand();
        $entity
            ->expects($this->once())
            ->method('getId')
            ->with()
            ->willReturn($id);

        $this->assertEquals($id, $transformer->transform($entity));
    }

    /**
     * Test transforming without int.
     */
    public function testIdToEntityNoId()
    {
        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $transformer = new EntityToIdTransformer($objectManager, 'class');

        $this->assertNull($transformer->reverseTransform(null));
        $this->assertNull($transformer->reverseTransform(''));
    }

    /**
     * Test when no result is found.
     */
    public function testIdToEntityNotFound()
    {
        $objectManager = $this->getMockBuilder('Doctrine\Common\Persistence\ObjectManager')
            ->getMock();

        $repo = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $repo
            ->expects($this->once())
            ->method('find');

        $objectManager
            ->expects($this->once())
            ->method('getRepository')
            ->willReturn($repo);


        $transformer = new EntityToIdTransformer($objectManager, 'class');

        $this->setExpectedException('Symfony\Component\Form\Exception\TransformationFailedException');
        $transformer->reverseTransform(1);
    }

    /**
     * Test found.
     */
    public function testIdToEntityFound()
    {
        $objectManager = $this->getMockBuilder('Doctrine\Common\Persistence\ObjectManager')
            ->getMock();

        $repo = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $result = new \stdClass();

        $repo
            ->expects($this->once())
            ->method('find')
            ->willReturn($result);

        $objectManager
            ->expects($this->once())
            ->method('getRepository')
            ->willReturn($repo);


        $transformer = new EntityToIdTransformer($objectManager, 'class');

        $this->assertEquals($result, $transformer->reverseTransform(1));
    }
}
