<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\NodeBundle\Tests\Unit\Node;

use Clastic\NodeBundle\Entity\Node;
use Clastic\NodeBundle\Event\NodeCreateEvent;
use Clastic\NodeBundle\Node\NodeManager;
use Clastic\NodeBundle\Tests\Stubs\NodeReferenceEntity;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeManagerTest extends TypeTestCase
{
    public function testCreateNode()
    {
        $nodeReferenceEntity = new NodeReferenceEntity();
        $registry = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $dispatcher = $this->getMockBuilder(EventDispatcher::class)
            ->getMock();
        $dispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->will($this->returnCallback(function ($name, NodeCreateEvent $event) use ($nodeReferenceEntity) {
                $event->setEntity($nodeReferenceEntity);

                return $event;
            }));

        $manager = new NodeManager($dispatcher, $registry);
        $this->assertEquals($nodeReferenceEntity, $manager->createNode('bla'));
    }

    public function testCreateNodeNotFound()
    {
        $this->setExpectedException('Exception');

        $nodeReferenceEntity = new NodeReferenceEntity();
        $registry = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $dispatcher = $this->getMockBuilder(EventDispatcher::class)
            ->getMock();
        $dispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->willReturnArgument(1);

        $manager = new NodeManager($dispatcher, $registry);
        $this->assertEquals($nodeReferenceEntity, $manager->createNode('bla'));
    }

    public function testLoadNodeFound()
    {
        $node = new Node();
        $node->setType('nodeType');

        $nodeReferenceEntity = new NodeReferenceEntity();

        $repository = $this->getMockBuilder(ObjectRepository::class)
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('find')
            ->willReturn($node);
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn($nodeReferenceEntity);

        $registry = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->exactly(2))
            ->method('getRepository')
            ->withConsecutive(array('ClasticNodeBundle:Node'), array(null))
            ->willReturnOnConsecutiveCalls($repository, $repository);

        $dispatcher = $this->getMockBuilder(EventDispatcher::class)
            ->getMock();
        $dispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->willReturnArgument(1);

        $manager = new NodeManager($dispatcher, $registry);
        $this->assertEquals($nodeReferenceEntity, $manager->loadNode(1));
    }

    public function testLoadNodeWithType()
    {
        $node = new Node();
        $node->setType('nodeType');

        $nodeReferenceEntity = new NodeReferenceEntity();

        $repository = $this->getMockBuilder(ObjectRepository::class)
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn($nodeReferenceEntity);

        $registry = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(null)
            ->willReturn($repository);

        $dispatcher = $this->getMockBuilder(EventDispatcher::class)
            ->getMock();
        $dispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->willReturnArgument(1);

        $manager = new NodeManager($dispatcher, $registry);
        $this->assertEquals($nodeReferenceEntity, $manager->loadNode(1, 'nodeType'));
    }

    public function testGetEntityName()
    {
        $registry = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $dispatcher = $this->getMockBuilder(EventDispatcher::class)
            ->getMock();
        $dispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->willReturnArgument(1);

        $manager = new NodeManager($dispatcher, $registry);
        $manager->getEntityName('type');
    }
}
