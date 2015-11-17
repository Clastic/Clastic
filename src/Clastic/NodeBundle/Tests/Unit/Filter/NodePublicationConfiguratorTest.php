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
use Clastic\NodeBundle\Filter\NodePublicationFilter;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\FilterCollection;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodePublicationConfiguratorTest extends TypeTestCase
{
    public function testNoToken()
    {
        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $tokenStorage = $this->getMockBuilder(TokenStorage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tokenStorage
            ->expects($this->once())
            ->method('getToken')
            ->willReturn(null);

        $configurator = new NodePublicationConfigurator($entityManager, $tokenStorage);
        $configurator->onKernelRequest();
    }

    public function testFull()
    {
        $nodePublicationFilter = $this->getMockBuilder(NodePublicationFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $nodePublicationFilter
            ->expects($this->once())
            ->method('setApplyPublication')
            ->withConsecutive([false]);

        $filterCollection = $this->getMockBuilder(FilterCollection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filterCollection
            ->expects($this->once())
            ->method('enable')
            ->willReturn($nodePublicationFilter);

        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getFilters')
            ->willReturn($filterCollection);

        $token = $this->getMockBuilder(UsernamePasswordToken::class)
            ->disableOriginalConstructor()
            ->getMock();
        $token
            ->expects($this->once())
            ->method('getProviderKey')
            ->willReturn('backoffice');

        $tokenStorage = $this->getMockBuilder(TokenStorage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tokenStorage
            ->expects($this->once())
            ->method('getToken')
            ->willReturn($token);

        $configurator = new NodePublicationConfigurator($entityManager, $tokenStorage);
        $configurator->onKernelRequest();
    }

    public function testOtherFirewall()
    {
        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->never())
            ->method('getFilters');

        $token = $this->getMockBuilder(UsernamePasswordToken::class)
            ->disableOriginalConstructor()
            ->getMock();
        $token
            ->expects($this->once())
            ->method('getProviderKey')
            ->willReturn('not_backoffice');

        $tokenStorage = $this->getMockBuilder(TokenStorage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tokenStorage
            ->expects($this->once())
            ->method('getToken')
            ->willReturn($token);

        $configurator = new NodePublicationConfigurator($entityManager, $tokenStorage);
        $configurator->onKernelRequest();
    }

    public function testOtherToken()
    {
        $filterCollection = $this->getMockBuilder(FilterCollection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filterCollection
            ->expects($this->never())
            ->method('enable');

        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->never())
            ->method('getFilters');

        $token = $this->getMockBuilder(TokenInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $token
            ->expects($this->never())
            ->method('getProviderKey');

        $tokenStorage = $this->getMockBuilder(TokenStorage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tokenStorage
            ->expects($this->once())
            ->method('getToken')
            ->willReturn($token);

        $configurator = new NodePublicationConfigurator($entityManager, $tokenStorage);
        $configurator->onKernelRequest();
    }
}
