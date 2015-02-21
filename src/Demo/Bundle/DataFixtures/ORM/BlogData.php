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
class BlogData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        /** @var NodeManager $nodeManager */
        $nodeManager = $this->container->get('clastic.node_manager');

        /** @var Blog $blog */
        $blog = $nodeManager->createNode('blog');
        $blog->getNode()->setTitle('First blogpost');
        $blog->setIntroduction('<p>Introduction</p>');
        $blog->setBody('<p>Some content</p>');
        $blog->getNode()->alias->setAlias('test');
        $blog->getNode()->setUser($this->getReference('user-demo'));

        $manager->persist($blog);
        $manager->flush();

        $this->setReference('demo-blog-first', $blog);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 20;
    }
}
