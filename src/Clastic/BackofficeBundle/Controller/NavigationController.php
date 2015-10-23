<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\Controller;

use Clastic\CoreBundle\Module\ModuleInterface;
use Clastic\CoreBundle\Module\ModuleManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * NodeController.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NavigationController extends Controller
{
    /**
     * @return Response
     */
    public function modulesAction()
    {
        $adminModules = $this->getModuleManager()->getAdministrationModules();
        uasort($adminModules, $this->getModuleSortCallback());

        $contentModules = $this->getModuleManager()->getContentModules();
        uasort($contentModules, $this->getModuleSortCallback());

        return $this->render('ClasticBackofficeBundle:Navigation:modules.html.twig', array(
            'administrationModules' => $adminModules,
            'modules' => $contentModules,
        ));
    }

    /**
     * Callback to sort the Modules by name.
     *
     * @return callable
     */
    private function getModuleSortCallback()
    {
        return function (ModuleInterface $left, ModuleInterface $right) {
            return strcmp($left->getName(), $right->getName());
        };
    }

    /**
     * @return Response
     */
    public function userAction()
    {
        return $this->render('ClasticBackofficeBundle:Navigation:user.html.twig');
    }

    /**
     * @return ModuleManager
     */
    private function getModuleManager()
    {
        return $this->get('clastic.module_manager');
    }
}
