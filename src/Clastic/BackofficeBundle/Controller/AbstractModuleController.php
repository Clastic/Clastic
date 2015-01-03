<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Controller;

use Clastic\CoreBundle\Module\NodeModuleInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * NodeController
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
     * @return Response
     */
    public function listAction()
    {
        $this->buildBreadcrumbs($this->getType());

        $queryBuilder = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('e')
            ->from($this->getEntityName($this->getType()), 'e')
            ->orderBy('e.id', 'DESC');

        $adapter = new DoctrineORMAdapter($queryBuilder);
        $data = new Pagerfanta($adapter);

        return $this->render($this->getListTemplate(), array(
            'data' => $data,
            'type' => $this->getType(),
            'module' => $this->get('clastic.module_manager')->getModule($this->getType()),
        ));
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
        $breadcrumbs->addItem($this->resolveDataTitle($data));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $this->persistData($data);

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Your changes were saved!');

            return $this->redirect($this->generateUrl('clastic_backoffice_form', array(
                'type' => $this->getType(),
                'id' => $data->getId(),
            )));
        }

        return $this->render('ClasticBackofficeBundle:Node:form.html.twig', array(
            'form' => $form->createView(),
            'module' => $this->get('clastic.module_manager')->getModule($this->getType()),
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

        $em = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success', sprintf('You deleted "%s"!', $title));

        return $this->redirect($this->generateUrl('clastic_backoffice_list', array(
            'type' => $this->getType(),
            'module' => $this->get('clastic.module_manager')->getModule($this->getType()),
        )));
    }

    /**
     * @param string $type
     *
     * @return Breadcrumbs
     */
    protected function buildBreadcrumbs($type)
    {
        /** @var NodeModuleInterface $module */
        $module = $this->get('clastic.module_manager')->getModule($type);

        /** @var Breadcrumbs $breadcrumbs */
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("clastic_backoffice_dashboard"));
        $breadcrumbs->addItem($module->getName(), $this->get("router")->generate("clastic_backoffice_list", array(
            'type' => $type,
        )));

        return $breadcrumbs;
    }

    /**
     * @param object $data
     */
    protected function persistData($data)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
    }
}
