<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\Tests\Unit\Form\DataTransformer;

use Clastic\BackofficeBundle\Form\DataTransformer\EntityToIdTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * EntityToldTransformerTest.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group unit
 */
class EntityToldTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test transforming entity to int.
     */
    public function testEntityToId()
    {
        $objectManager = $this->getMock(ObjectManager::class);
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
        $objectManager = $this->getMock(ObjectManager::class);
        $transformer = new EntityToIdTransformer($objectManager, 'class');

        $this->assertNull($transformer->reverseTransform(null));
        $this->assertNull($transformer->reverseTransform(''));
    }

    /**
     * Test when no result is found.
     */
    public function testIdToEntityNotFound()
    {
        $objectManager = $this->getMockBuilder(ObjectManager::class)
            ->getMock();

        $repo = $this->getMockBuilder(EntityRepository::class)
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

        $this->setExpectedException(TransformationFailedException::class);
        $transformer->reverseTransform(1);
    }

    /**
     * Test found.
     */
    public function testIdToEntityFound()
    {
        $objectManager = $this->getMockBuilder(ObjectManager::class)
            ->getMock();

        $repo = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $result = new \stdClass();

        $repo
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($result);

        $objectManager
            ->expects($this->once())
            ->method('getRepository')
            ->with('class')
            ->willReturn($repo);

        $transformer = new EntityToIdTransformer($objectManager, 'class');

        $this->assertEquals($result, $transformer->reverseTransform(1));
    }
}
