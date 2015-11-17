<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\NodeBundle\Tests\Unit\Filter;

use Clastic\NodeBundle\Filter\NodePublicationFilter;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetaData;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodePublicationFilterTest extends TypeTestCase
{
    public function testDisabled()
    {
        $classMetadata = $this->getMockBuilder(ClassMetaData::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filter = new NodePublicationFilter($entityManager);

        $filter->setApplyPublication(false);

        $this->assertEquals('', $filter->addFilterConstraint($classMetadata, 'alias'));
    }

    public function testNoNode()
    {
        $classMetadata = $this->getMockBuilder(ClassMetaData::class)
            ->disableOriginalConstructor()
            ->getMock();
        $classMetadata->reflClass = $this->getMockBuilder(\ReflectionClass::class)
            ->disableOriginalConstructor()
            ->getMock();
        $classMetadata->reflClass
            ->expects($this->once())
            ->method('implementsInterface');

        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filter = new NodePublicationFilter($entityManager);

        $this->assertEquals('', $filter->addFilterConstraint($classMetadata, 'alias'));
    }

    public function testNode()
    {
        $classMetadata = $this->getMockBuilder(ClassMetaData::class)
            ->disableOriginalConstructor()
            ->getMock();
        $classMetadata->reflClass = $this->getMockBuilder(\ReflectionClass::class)
            ->disableOriginalConstructor()
            ->getMock();
        $classMetadata->reflClass
            ->expects($this->once())
            ->method('implementsInterface')
            ->willReturn(true);

        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filter = new NodePublicationFilter($entityManager);

        $query = $filter->addFilterConstraint($classMetadata, 'alias');
        $this->assertContains('publishedFrom', $query);
        $this->assertContains('publishedTill', $query);
        $this->assertContains('NodePublication', $query);
        $this->assertContains('alias', $query);
    }
}
