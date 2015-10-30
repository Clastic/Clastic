<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\Controller;

use Clastic\BackofficeBundle\Form\Type\DeleteFormType;
use Clastic\CoreBundle\Module\ModuleInterface;
use Clastic\CoreBundle\Module\SubmoduleInterface;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * NodeController.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
abstract class AbstractModuleController extends Controller
{
    /**
     * @return string
     */
    abstract protected function getType();

    /**
     * @param int|null $id
     *
     * @return mixed
     */
    abstract protected function resolveData($id);

    /**
     * @return string
     */
    abstract protected function getListTemplate();

    /**
     * @param object $data
     *
     * @return Form
     */
    abstract protected function buildForm($data);

    /**
     * @param object $data
     *
     * @return string
     */
    abstract protected function resolveDataTitle($data);

    /**
     * @return string
     */
    abstract protected function getEntityName();

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        $this->buildBreadcrumbs($this->getType());

        $queryBuilder = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('e')
            ->from($this->getEntityName($this->getType()), 'e')
            ->orderBy('e.id', 'DESC');

        $adapter = new DoctrineORMAdapter($this->alterListQuery($queryBuilder));
        $data = new Pagerfanta($adapter);
        $data->setCurrentPage($request->query->get('page', 1));

        $module = $this->getModule($this->getType());

        return $this->render($this->getListTemplate(), array_merge(array(
            'data' => $data,
            'type' => $this->getType(),
            'module' => $module,
            'submodules' => $this->getSubmodules($module),
        ), $this->getExtraListVariables()));
    }

    /**
     * @return array
     */
    protected function getExtraListVariables()
    {
        return array();
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return QueryBuilder
     */
    protected function alterListQuery(QueryBuilder $queryBuilder)
    {
        return $queryBuilder;
    }

    /**
     * @param int|null $id
     * @param Request  $request
     *
     * @return RedirectResponse|Response
     */
    public function formAction($id, Request $request)
    {
        $data = $this->resolveData($id);
        $form = $this->buildForm($data);

        $breadcrumbs = $this->buildBreadcrumbs($this->getType());
        if (!$data->getId()) {
            $breadcrumbs->addItem('navigation.new');
        } else {
            $breadcrumbs->addItem($this->resolveDataTitle($data));
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $this->persistData($form);

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Your changes were saved!');

            return $this->redirect($this->getFormSuccessUrl($data));
        }

        $module = $this->getModule($this->getType());

        return $this->render('ClasticNodeBundle:Backoffice/Node:form.html.twig', array(
            'form' => $form->createView(),
            'module' => $module,
            'submodules' => $this->getSubmodules($module),
        ));
    }

    /**
     * @param object $data
     *
     * @return string
     */
    protected function getFormSuccessUrl($data)
    {
        return $this->generateUrl('clastic_node_list', array(
            'type' => $this->getType(),
        ));
    }

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function deleteAction($id, Request $request)
    {
        $data = $this->resolveData($id);
        $title = $this->resolveDataTitle($data);

        $breadcrumbs = $this->buildBreadcrumbs($this->getType());
        $breadcrumbs->addItem(sprintf('Delete "%s"', $this->resolveDataTitle($data)));

        $form = $this->createForm(new DeleteFormType(), array(
            'id' => $data->getId(),
            'title' => $title,
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($form->get('tabs')->get('actions')->get('delete')->isClicked()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($data);
                $manager->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', sprintf('You deleted "%s"!', $title));
            }

            if ($request->query->has('_return')) {
                $redirectUrl = $this->generateUrl($request->query->get('_return'));
            } else {
                $redirectUrl = $this->getListUrl();
            }

            return $this->redirect($redirectUrl);
        }

        $module = $this->getModule($this->getType());

        return $this->render('ClasticNodeBundle:Backoffice/Node:form.html.twig', array(
            'page_title' => sprintf('Delete "%s"?', $title),
            'form' => $form->createView(),
            'module' => $module,
            'submodules' => $this->getSubmodules($module),
        ));
    }

    /**
     * @return string
     */
    protected function getListUrl()
    {
        return $this->generateUrl('clastic_node_list', array(
            'type' => $this->getType(),
            'module' => $this->getModule($this->getType()),
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
        $breadcrumbs->addItem(
            'navigation.home',
            $this->get('router')->generate('clastic_backoffice_dashboard')
        );

        $module = $this->getModule($type);
        if ($module) {
            $this->buildModuleBreadcrumb($breadcrumbs, $module);
        }

        return $breadcrumbs;
    }

    /**
     * @param Breadcrumbs     $breadcrumbs
     * @param ModuleInterface $module
     */
    protected function buildModuleBreadcrumb(Breadcrumbs $breadcrumbs, ModuleInterface $module)
    {
        if ($module instanceof SubmoduleInterface) {
            $parentModule = $this->getModule($module->getParentIdentifier());
            $this->buildModuleBreadcrumb($breadcrumbs, $parentModule);
        }

        $breadcrumbs->addItem($module->getName(), $this->get('router')->generate('clastic_node_list', array(
            'type' => $module->getIdentifier(),
        )));
    }

    /**
     * @param Form $form
     */
    protected function persistData(Form $form)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($form->getData());
        $manager->flush();
    }

    /**
     * @param string $identifier
     *
     * @return ModuleInterface
     */
    private function getModule($identifier)
    {
        return $this->get('clastic.module_manager')
            ->getModule($identifier);
    }

    /**
     * @param ModuleInterface $module
     *
     * @return SubmoduleInterface[]
     */
    private function getSubmodules(ModuleInterface $module)
    {
        if ($module instanceof SubmoduleInterface) {
            $module = $this->getModule($module->getParentIdentifier());
        }

        return $this->get('clastic.module_manager')
            ->getSubmodules($module->getIdentifier());
    }
}
