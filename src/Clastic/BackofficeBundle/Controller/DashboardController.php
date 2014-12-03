<?php

namespace Clastic\BackofficeBundle\Controller;

use Clastic\CoreBundle\Module\ModuleManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
