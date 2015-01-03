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
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * DashboardController
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class DashboardController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $this->buildBreadcrumbs();

        return $this->render('ClasticBackofficeBundle:Dashboard:index.html.twig', array(
            'modules' => $this->getModuleManager()->getModules(),
            'myContent' => $this->getMyContent(),
            'recent' => $this->getRecent(),
        ));
    }

    /**
     * @return Pagerfanta
     */
    private function getMyContent()
    {
        $queryBuilder = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('e')
            ->from('ClasticCoreBundle:Node', 'e')
            ->where('e.user = :user')
            ->orderBy('e.id', 'DESC')
            ->setParameters(array(
                'user' => $this->get('security.context')->getToken()->getUser(),
            ));

        $adapter = new DoctrineORMAdapter($queryBuilder);
        $data = new Pagerfanta($adapter);

        return $data;
    }


    /**
     * @return Pagerfanta
     */
    private function getRecent()
    {
        $queryBuilder = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('e')
            ->from('ClasticCoreBundle:Node', 'e')
            ->orderBy('e.changed', 'DESC');

        $adapter = new DoctrineORMAdapter($queryBuilder);
        $data = new Pagerfanta($adapter);

        return $data;
    }

    /**
     * @return Breadcrumbs
     */
    protected function buildBreadcrumbs()
    {
        /** @var Breadcrumbs $breadcrumbs */
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("clastic_backoffice_dashboard"));

        return $breadcrumbs;
    }

    /**
     * @return ModuleManager
     */
    private function getModuleManager()
    {
        return $this->get('clastic.module_manager');
    }
}
