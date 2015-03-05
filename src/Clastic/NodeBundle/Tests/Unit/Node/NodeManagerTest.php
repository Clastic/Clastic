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
        $registry = $this->getMockBuilder('Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->getMock();
        $dispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcher')
            ->getMock();
        $dispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->will($this->returnCallback(function($name, NodeCreateEvent $event) use ($nodeReferenceEntity) {
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
        $registry = $this->getMockBuilder('Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->getMock();
        $dispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcher')
            ->getMock();
        $dispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->willReturnArgument(1);

        $manager = new NodeManager($dispatcher, $registry);
        $this->assertEquals($nodeReferenceEntity, $manager->createNode('bla'));
    }
}
