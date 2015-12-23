<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\NodeBundle\Tests\Unit\EventListener;

use Clastic\CoreBundle\Module\ModuleManager;
use Clastic\NodeBundle\Entity\Node;
use Clastic\NodeBundle\Event\NodeCreateEvent;
use Clastic\NodeBundle\Event\NodeResolveEntityNameEvent;
use Clastic\NodeBundle\EventListener\NodeListener;
use Clastic\NodeBundle\Module\NodeModuleInterface;
use Clastic\NodeBundle\Tests\Stubs\NodeReferenceEntity;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeListenerTest extends TypeTestCase
{
    public function testCreateEntityEventNotFound()
    {
        $this->setExpectedException(\Exception::class);

        $moduleManager = $this->getMockBuilder(ModuleManager::class)
            ->getMock();

        $registry = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $listener = new NodeListener($moduleManager, $registry);

        $event = new NodeCreateEvent('type', new Node());

        $listener->createEntity($event);
    }

    public function testCreateEntityEventFound()
    {
        $module = $this->getMockBuilder(NodeModuleInterface::class)
            ->getMockForAbstractClass();

        $moduleManager = $this->getMockBuilder(ModuleManager::class)
            ->getMock();
        $moduleManager
            ->expects($this->once())
            ->method('getModule')
            ->willReturn($module);

        $repo = $this->getMockBuilder(ObjectRepository::class)
            ->getMock();
        $repo
            ->expects($this->once())
            ->method('getClassName')
            ->willReturn(NodeReferenceEntity::class);

        $registry = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->willReturn($repo);

        $event = new NodeCreateEvent('type', new Node());
        $listener = new NodeListener($moduleManager, $registry);

        $listener->createEntity($event);

        $this->assertInstanceOf(NodeReferenceEntity::class, $event->getEntity());
    }

    public function testResolveEntityName()
    {
        $module = $this->getMockBuilder(NodeModuleInterface::class)
            ->getMockForAbstractClass();
        $module
            ->expects($this->once())
            ->method('getEntityName')
            ->willReturn('EntityName');

        $moduleManager = $this->getMockBuilder(ModuleManager::class)
            ->getMock();
        $moduleManager
            ->expects($this->once())
            ->method('getModule')
            ->willReturn($module);

        $registry = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event = new NodeResolveEntityNameEvent('type');
        $listener = new NodeListener($moduleManager, $registry);

        $listener->resolveEntityName($event);

        $this->assertEquals('EntityName', $event->getEntityName());
    }
}
