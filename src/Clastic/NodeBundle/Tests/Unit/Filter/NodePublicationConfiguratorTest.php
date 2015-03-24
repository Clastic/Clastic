<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NodeBundle\Tests\Unit\Filter;

use Clastic\NodeBundle\Filter\NodePublicationConfigurator;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodePublicationConfiguratorTest extends TypeTestCase
{
    public function testNoToken()
    {
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $securityContext = $this->getMockBuilder('Symfony\Component\Security\Core\SecurityContext')
            ->disableOriginalConstructor()
            ->getMock();
        $securityContext
            ->expects($this->once())
            ->method('getToken')
            ->willReturn(null);

        $configurator = new NodePublicationConfigurator($entityManager, $securityContext);
        $configurator->onKernelRequest();
    }

    public function testFull()
    {
        $nodePublicationFilter = $this->getMockBuilder('Clastic\NodeBundle\Filter\NodePublicationFilter')
            ->disableOriginalConstructor()
            ->getMock();
        $nodePublicationFilter
            ->expects($this->once())
            ->method('setApplyPublication')
            ->withConsecutive([false]);

        $filterCollection = $this->getMockBuilder('Doctrine\ORM\Query\FilterCollection')
            ->disableOriginalConstructor()
            ->getMock();
        $filterCollection
            ->expects($this->once())
            ->method('enable')
            ->willReturn($nodePublicationFilter);

        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getFilters')
            ->willReturn($filterCollection);

        $token = $this->getMockBuilder('Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken')
            ->disableOriginalConstructor()
            ->getMock();
        $token
            ->expects($this->once())
            ->method('getProviderKey')
            ->willReturn('backoffice');

        $securityContext = $this->getMockBuilder('Symfony\Component\Security\Core\SecurityContext')
            ->disableOriginalConstructor()
            ->getMock();
        $securityContext
            ->expects($this->once())
            ->method('getToken')
            ->willReturn($token);

        $configurator = new NodePublicationConfigurator($entityManager, $securityContext);
        $configurator->onKernelRequest();
    }

    public function testOtherFirewall()
    {
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->never())
            ->method('getFilters');

        $token = $this->getMockBuilder('Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken')
            ->disableOriginalConstructor()
            ->getMock();
        $token
            ->expects($this->once())
            ->method('getProviderKey')
            ->willReturn('not_backoffice');

        $securityContext = $this->getMockBuilder('Symfony\Component\Security\Core\SecurityContext')
            ->disableOriginalConstructor()
            ->getMock();
        $securityContext
            ->expects($this->once())
            ->method('getToken')
            ->willReturn($token);

        $configurator = new NodePublicationConfigurator($entityManager, $securityContext);
        $configurator->onKernelRequest();
    }

    public function testOtherToken()
    {
        $filterCollection = $this->getMockBuilder('Doctrine\ORM\Query\FilterCollection')
            ->disableOriginalConstructor()
            ->getMock();
        $filterCollection
            ->expects($this->never())
            ->method('enable');

        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->never())
            ->method('getFilters');

        $token = $this->getMockBuilder('Symfony\Component\Security\Core\Authentication\Token\TokenInterface')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $token
            ->expects($this->never())
            ->method('getProviderKey');

        $securityContext = $this->getMockBuilder('Symfony\Component\Security\Core\SecurityContext')
            ->disableOriginalConstructor()
            ->getMock();
        $securityContext
            ->expects($this->once())
            ->method('getToken')
            ->willReturn($token);

        $configurator = new NodePublicationConfigurator($entityManager, $securityContext);
        $configurator->onKernelRequest();
    }
}
