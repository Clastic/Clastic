<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NodeBundle\Tests\Unit\EventListener;

use Clastic\NodeBundle\Entity\Node;
use Clastic\NodeBundle\Event\NodeCreateEvent;
use Clastic\NodeBundle\Event\NodeResolveEntityNameEvent;
use Clastic\NodeBundle\EventListener\NodeListener;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeListenerTest extends TypeTestCase
{
    public function testCreateEntityEventNotFound()
    {
        $this->setExpectedException('Exception');

        $moduleManager = $this->getMockBuilder('Clastic\CoreBundle\Module\ModuleManager')
            ->getMock();

        $registry = $this->getMockBuilder('Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->getMock();

        $listener = new NodeListener($moduleManager, $registry);

        $event = new NodeCreateEvent('type', new Node());

        $listener->createEntity($event);
    }

    public function testCreateEntityEventFound()
    {
        $module = $this->getMockBuilder('Clastic\NodeBundle\Module\NodeModuleInterface')
            ->getMockForAbstractClass();

        $moduleManager = $this->getMockBuilder('Clastic\CoreBundle\Module\ModuleManager')
            ->getMock();
        $moduleManager
            ->expects($this->once())
            ->method('getModule')
            ->willReturn($module);

        $repo = $this->getMockBuilder('Doctrine\Common\Persistence\ObjectRepository')
            ->getMock();
        $repo
            ->expects($this->once())
            ->method('getClassName')
            ->willReturn('Clastic\NodeBundle\Tests\Stubs\NodeReferenceEntity');

        $registry = $this->getMockBuilder('Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->willReturn($repo);

        $event = new NodeCreateEvent('type', new Node());
        $listener = new NodeListener($moduleManager, $registry);

        $listener->createEntity($event);

        $this->assertInstanceOf('Clastic\NodeBundle\Tests\Stubs\NodeReferenceEntity', $event->getEntity());
    }

    public function testResolveEntityName()
    {
        $module = $this->getMockBuilder('Clastic\NodeBundle\Module\NodeModuleInterface')
            ->getMockForAbstractClass();
        $module
            ->expects($this->once())
            ->method('getEntityName')
            ->willReturn('EntityName');

        $moduleManager = $this->getMockBuilder('Clastic\CoreBundle\Module\ModuleManager')
            ->getMock();
        $moduleManager
            ->expects($this->once())
            ->method('getModule')
            ->willReturn($module);

        $registry = $this->getMockBuilder('Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->getMock();

        $event = new NodeResolveEntityNameEvent('type');
        $listener = new NodeListener($moduleManager, $registry);

        $listener->resolveEntityName($event);

        $this->assertEquals('EntityName', $event->getEntityName());
    }
}
