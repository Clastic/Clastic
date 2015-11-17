<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\Tests\Unit\Controller;

use Clastic\BackofficeBundle\Tests\AuthenticatedWebTestCase;
use Clastic\BackofficeBundle\Twig\AvatarExtension;
use Clastic\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group unit
 */
class AvatarExtensionTest extends AuthenticatedWebTestCase
{
    public function testEmailNoUser()
    {
        $tokenStorage = $this->getMockBuilder(TokenStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $extension = new AvatarExtension($tokenStorage);

        $this->assertNull($extension->getUserEmail());
    }

    public function testEmail()
    {
        $securityContext = $this->getMockBuilder(TokenStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $user = new User();
        $user->setEmail('test@clastic.be');

        $token = $this->getMockBuilder(UsernamePasswordToken::class)
            ->disableOriginalConstructor()
            ->getMock();
        $token
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($user);

        $securityContext
            ->expects($this->once())
            ->method('getToken')
            ->willReturn($token);

        $extension = new AvatarExtension($securityContext);

        $this->assertEquals('test@clastic.be', $extension->getUserEmail());
    }
}
