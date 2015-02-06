<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Demo\Bundle\DataFixtures\ORM;

use Clastic\BlogBundle\Entity\Blog;
use Clastic\MenuBundle\Entity\MenuItem;
use Clastic\NodeBundle\Node\NodeManager;
use Clastic\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class MenuData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $menuItemHome = new MenuItem();
        $menuItemHome->setMenu($this->getReference('menu-main'));
        $menuItemHome->setTitle('Home');
        $menuItemHome->setUrl('/');
        $manager->persist($menuItemHome);

        $menuItemBlog = new MenuItem();
        $menuItemBlog->setMenu($this->getReference('menu-main'));
        $menuItemBlog->setTitle('Test blog');
        $menuItemBlog->setNode($this->getReference('demo-blog-first')->getNode());
        $manager->persist($menuItemBlog);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 21;
    }
}
