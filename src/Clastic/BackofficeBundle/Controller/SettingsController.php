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
use Clastic\CoreBundle\Module\SubmoduleInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * SettingsController.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class SettingsController extends Controller
{
    /**
     * @param Request $request
     * @param string  $type
     *
     * @return Response
     */
    public function formAction(Request $request, $type)
    {
        $this->buildBreadcrumbs($type);

        $form = $this->createForm('clastic_settings', array('module' => $type));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Your changes were saved!');

            return $this->redirect($request->getPathInfo());
        }

        return $this->render('ClasticBackofficeBundle:Settings:form.html.twig', array(
            'form' => $form->createView(),
            'module' => $this->getModuleManager()->getModule($type),
        ));
    }

    /**
     * @param string $type
     *
     * @return Breadcrumbs
     */
    protected function buildBreadcrumbs($type)
    {
        /** @var Breadcrumbs $breadcrumbs */
        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem('Home', $this->get('router')->generate('clastic_backoffice_dashboard'));

        $module = $this->getModuleManager()->getModule($type);
        if ($module) {
            $this->buildModuleBreadcrumb($breadcrumbs, $module);
        }

        $breadcrumbs->addItem('Settings', $this->get('router')->generate('clastic_backoffice_setting', array(
            'type' => $type,
        )));

        return $breadcrumbs;
    }

    /**
     * @param Breadcrumbs     $breadcrumbs
     * @param ModuleInterface $module
     */
    protected function buildModuleBreadcrumb(Breadcrumbs $breadcrumbs, ModuleInterface $module)
    {
        if ($module instanceof SubmoduleInterface) {
            $parentModule = $this->getModuleManager()->getModule($module->getParentIdentifier());
            $this->buildModuleBreadcrumb($breadcrumbs, $parentModule);
        }

        $breadcrumbs->addItem($module->getName(), $this->get('router')->generate('clastic_node_list', array(
            'type' => $module->getIdentifier(),
        )));
    }

    /**
     * @return ModuleManager
     */
    private function getModuleManager()
    {
        return $this->get('clastic.module_manager');
    }
}
