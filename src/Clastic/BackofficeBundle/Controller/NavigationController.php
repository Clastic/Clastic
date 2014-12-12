<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Controller;

use Clastic\BackofficeBundle\Form\NodeDeleteType;
use Clastic\CoreBundle\Entity\Node;
use Clastic\BackofficeBundle\Form\NodeType;
use Clastic\CoreBundle\Module\ModuleManager;
use Clastic\TextBundle\Entity\Text;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * NodeController
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NavigationController extends Controller
{
    public function modulesAction()
    {
        return $this->render('ClasticBackofficeBundle:Navigation:modules.html.twig', array(
                'modules' => $this->getModuleManager()->getModules(),
        ));
    }

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
