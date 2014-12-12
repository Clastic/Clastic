<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Controller;

use Clastic\CoreBundle\Module\ModuleManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * DashboardController
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClasticBackofficeBundle:Dashboard:index.html.twig', array(
              'modules' => $this->getModuleManager()->getModules(),
          ));
    }

    /**
     * @return ModuleManager
     */
    private function getModuleManager()
    {
        return $this->get('clastic.module_manager');
    }
}
