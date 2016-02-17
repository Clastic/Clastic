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
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Symfony\Component\Form\Test\TypeTestCase;
use Zend\Hydrator\Reflection;

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

        $metadataInfo = $this->getMockBuilder(ClassMetadataInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $metadataInfo
            ->expects($this->exactly(2))
            ->method('getTableName')
            ->willReturn('placeholder');

        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager
            ->expects($this->exactly(2))
            ->method('getClassMetadata')
            ->willReturn($metadataInfo);

        $filter = new NodePublicationFilter($entityManager);
        $reflector = new \ReflectionClass($filter);
        $property = $reflector->getParentClass()
            ->getProperty('em');
        $property->setAccessible(true);
        $property->setValue($filter, $entityManager);

        $query = $filter->addFilterConstraint($classMetadata, 'alias');

        $this->assertContains('publishedFrom', $query);
        $this->assertContains('publishedTill', $query);
        $this->assertContains('placeholder', $query);
        $this->assertContains('alias', $query);
    }
}
