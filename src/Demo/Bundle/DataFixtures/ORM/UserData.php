<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dome\Bundle\DataFixtures\ORM;

use Clastic\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class UserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $demoUser = new User();
        $demoUser->setUsername('demo');
        $demoUser->setEmail('dries@nousefreak.be');
        $demoUser->addRole('ROLE_ADMIN');
        $demoUser->setPlainPassword('demo');
        $demoUser->setEnabled(true);

        $userManager = $this->container->get('fos_user.user_manager');
        $userManager->updateUser($demoUser);

        $manager->persist($demoUser);
        $manager->flush();

        $this->addReference('user-demo', $demoUser);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 10;
    }
}
