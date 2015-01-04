<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\AliasBundle\EventListener;

use Clastic\AliasBundle\Entity\Alias;
use Clastic\NodeBundle\Event\NodeCreateEvent;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use ProxyManager\Proxy\ValueHolderInterface;

/**
 * NodeListener
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeListener implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::postLoad,
            Events::postPersist,
            Events::postRemove,
        );
    }

    /**
     * @param NodeCreateEvent $event
     */
    public function create(NodeCreateEvent $event)
    {
        $event->getNode()->alias = new Alias();
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof NodeReferenceInterface) {
            $node = $entity->getNode();
            $factory = new LazyLoadingValueHolderFactory();

            $node->alias = $factory->createProxy(
                'Clastic\AliasBundle\Entity\Alias',
                function (&$wrappedObject, $proxy, $method, $parameters, & $initializer) use ($args, $node) {
                    $wrappedObject = $args->getObjectManager()
                        ->getRepository('ClasticAliasBundle:Alias')
                        ->findOneBy(array(
                            'node' => $node,
                        ));
                    $initializer = null;

                    return true;
                }
            );
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof NodeReferenceInterface) {

            $node = $entity->getNode();

            $alias = $node->alias;
            if ($alias instanceof ValueHolderInterface) {
                $node->alias->getId();
                $alias = $alias->getWrappedValueHolderValue();
            }

            $alias->setNode($node);
            $alias->setPath(sprintf('node/%s', $node->getId()));

            $args->getObjectManager()
                ->persist($alias);
            $args->getObjectManager()
                ->flush();
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof NodeReferenceInterface) {
            $alias = $entity->getNode()->alias;

            if ($alias instanceof ValueHolderInterface) {
                $alias->getId();
                $alias = $alias->getWrappedValueHolderValue();
            }

            $alias->getId();
            $args->getObjectManager()
                ->remove($alias);
            $args->getObjectManager()
                ->flush();
        }
    }
}
