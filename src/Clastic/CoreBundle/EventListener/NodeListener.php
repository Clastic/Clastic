<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CoreBundle\EventListener;

use Clastic\CoreBundle\Event\NodeCreateEntityEvent;
use Clastic\CoreBundle\Event\NodeResolveEntityNameEvent;
use Clastic\CoreBundle\Module\ModuleManager;
use Clastic\CoreBundle\Module\NodeModuleInterface;
use Clastic\CoreBundle\NodeEvents;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * NodeListener
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeListener implements EventSubscriberInterface
{
    /**
     * @var ModuleManager
     */
    private $moduleManager;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @param ModuleManager $moduleManager
     * @param Registry      $registry
     */
    public function __construct(ModuleManager $moduleManager, Registry $registry)
    {
        $this->moduleManager = $moduleManager;
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            NodeEvents::RESOLVE_ENTITY_NAME => 'resolveEntityName',
            NodeEvents::CREATE_ENTITY => 'createEntity',
        );
    }

    /**
     * @param NodeResolveEntityNameEvent $event
     *
     * @throws \Exception
     */
    public function resolveEntityName(NodeResolveEntityNameEvent $event)
    {
        $event->setEntityName($this->lookupEntityName($event->getType()));
    }

    /**
     * @param string $type
     *
     * @return string
     *
     * @throws \Exception
     */
    private function lookupEntityName($type)
    {
        $module = $this->moduleManager->getModule($type);

        if (! $module instanceof NodeModuleInterface) {
            throw new \Exception(sprintf('Type "%s" is not a NodeModule.', $type));
        }

        return $module->getEntityName();
    }

    /**
     * @param NodeCreateEntityEvent $event
     *
     * @throws \Exception
     */
    public function createEntity(NodeCreateEntityEvent $event)
    {
        $className = $this->registry
            ->getRepository($this->lookupEntityName($event->getType()))
            ->getClassName();

        $event->setEntity(new $className());
    }

}
