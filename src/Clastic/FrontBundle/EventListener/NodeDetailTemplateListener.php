<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\FrontBundle\EventListener;

use Clastic\CoreBundle\Module\ModuleManager;
use Clastic\FrontBundle\Event\FrontNodeEvent;
use Clastic\NodeBundle\Module\NodeModuleInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * NodeListener.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeDetailTemplateListener implements EventSubscriberInterface
{
    /**
     * @var ModuleManager
     */
    private $moduleManager;

    /**
     * @param ModuleManager $manager
     */
    public function __construct(ModuleManager $manager)
    {
        $this->moduleManager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'clastic.node.front' => array('setTemplate', 10),
        );
    }

    /**
     * @param FrontNodeEvent $event
     */
    public function setTemplate(FrontNodeEvent $event)
    {
        $module = $this->moduleManager->getModule($event->getNode()->getType());
        if (!$module instanceof NodeModuleInterface) {
            return;
        }

        $template = $module->getDetailTemplate();
        if (!$template) {
            return;
        }

        $event->setTemplate($template);
    }
}
