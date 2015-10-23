<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\Controller;

use Clastic\BackofficeBundle\BackofficeEvents;
use Clastic\BackofficeBundle\Event\DashboardEvent;
use Clastic\CoreBundle\Module\ModuleManager;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * DashboardController.
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

        $mainTab = array(
            'recent' => array(
                'title' => 'dashboard.recent',
                'content' => $this->renderView('ClasticBackofficeBundle:Dashboard:contentList.html.twig', array(
                    'records' => $this->getRecent(),
                    'moduleManager' => $this->getModuleManager(),
                )),
            ),
            'my_content' => array(
                'title' => 'dashboard.my_content',
                'content' => $this->renderView('ClasticBackofficeBundle:Dashboard:contentList.html.twig', array(
                    'records' => $this->getMyContent(),
                    'moduleManager' => $this->getModuleManager(),
                )),
            ),
        );

        $event = new DashboardEvent($mainTab);
        $this->get('event_dispatcher')->dispatch(BackofficeEvents::DASHBOARD, $event);

        return $this->render('ClasticBackofficeBundle:Dashboard:index.html.twig', array(
            'mainTabs' => $event->getMainTab(),
            'moduleManager' => $this->getModuleManager(),
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
            ->from('ClasticNodeBundle:Node', 'e')
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
            ->from('ClasticNodeBundle:Node', 'e')
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
        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem('Home', $this->get('router')->generate('clastic_backoffice_dashboard'));

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
