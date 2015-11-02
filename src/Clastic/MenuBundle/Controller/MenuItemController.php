<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\MenuBundle\Controller;

use Clastic\BackofficeBundle\Controller\AbstractModuleController;
use Clastic\MenuBundle\Entity\Menu;
use Clastic\MenuBundle\Entity\MenuItem;
use Clastic\MenuBundle\Form\Type\MenuItemFormType;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Doctrine\ORM\QueryBuilder;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * MenuItemController.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class MenuItemController extends AbstractModuleController
{
    protected $menuId;

    /**
     * @return string
     */
    protected function getType()
    {
        return 'menu';
    }

    /**
     * @return string
     */
    protected function getListTemplate()
    {
        return 'ClasticMenuBundle:Backoffice:item_list.html.twig';
    }

    /**
     * @param object $data
     *
     * @return Form
     */
    protected function buildForm($data)
    {
        return $this->createForm(new MenuItemFormType($this->get('router')), $data);
    }

    /**
     * @param object $data
     *
     * @return string
     */
    protected function resolveDataTitle($data)
    {
        return $data->getTitle();
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'ClasticMenuBundle:MenuItem';
    }

    /**
     * @param int $id
     *
     * @return NodeReferenceInterface
     */
    protected function resolveData($id)
    {
        if (!is_null($id)) {
            return $this->getDoctrine()->getRepository($this->getEntityName())
                ->find($id);
        }

        $em = $this->getDoctrine()->getEntityManager();

        $menuItem = new MenuItem();
        $menuItem->setMenu($em->getReference('ClasticMenuBundle:Menu', $this->menuId));

        return $menuItem;
    }

    /**
     * @param Request  $request
     * @param null|int $menuId
     *
     * @return Response
     */
    public function listAction(Request $request, $menuId = null)
    {
        $this->menuId = $menuId;

        return parent::listAction($request);
    }

    /**
     * @param int      $id
     * @param Request  $request
     * @param null|int $menuId
     *
     * @return RedirectResponse
     */
    public function deleteAction($id, Request $request, $menuId = null)
    {
        $this->menuId = $menuId;

        return parent::deleteAction($id, $request);
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return QueryBuilder
     */
    protected function alterListQuery(QueryBuilder $queryBuilder)
    {
        $entityManager = $this->getDoctrine()->getEntityManager();

        $queryBuilder->andWhere('e.menu = :menu');
        $queryBuilder->setParameter('menu', $entityManager->getReference('ClasticMenuBundle:Menu', $this->menuId));

        return $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function formAction($id, Request $request, $menuId = null)
    {
        $this->menuId = $menuId;

        return parent::formAction($id, $request);
    }

    /**
     * @return array
     */
    protected function getExtraListVariables()
    {
        return array(
            'menuId' => $this->menuId,
        );
    }

    /**
     * @param object $data
     *
     * @return string
     */
    protected function getFormSuccessUrl($data)
    {
        return $this->getListUrl();
    }

    /**
     * @return string
     */
    protected function getListUrl()
    {
        return $this->generateUrl('clastic_backoffice_menu_item_list', array(
            'menuId' => $this->menuId,
        ));
    }

    /**
     * @param string $type
     *
     * @return Breadcrumbs
     */
    protected function buildBreadcrumbs($type)
    {
        /** @var TranslatorInterface $translator */
        $translator = $this->get('translator');

        $breadcrumbs = parent::buildBreadcrumbs($type);

        $breadcrumbs->addItem($this->getCurrentMenu()->getTitle(), $this->get('router')->generate('clastic_backoffice_menu_form', array(
            'id' => $this->menuId,
        )));

        $breadcrumbs->addItem(
            $translator->trans('Items', [], 'clastic'),
            $this->get('router')->generate('clastic_backoffice_menu_item_list', array(
                'menuId' => $this->menuId,
            ))
        );

        return $breadcrumbs;
    }

    /**
     * @return Menu
     */
    private function getCurrentMenu()
    {
        return $this->get('doctrine')
            ->getRepository('ClasticMenuBundle:Menu')
            ->find($this->menuId);
    }

    /**
     * @param Form $form
     *
     * @throws \Doctrine\ORM\ORMException
     */
    protected function persistData(Form $form)
    {
        parent::persistData($form);

        $positionData = $form->get('tabs')->get('position_tab')->get('position')->getNormData();

        if ($positionData) {
            $positionData = json_decode($positionData);
            /** @var MenuItem $data */
            $data = $form->getData();

            $entityManager = $this->getDoctrine()->getEntityManager();
            /** @var NestedTreeRepository $menuItemRepo */
            $menuItemRepo = $this->getDoctrine()->getRepository($this->getEntityName());

            $positionData->parent = intval($positionData->parent) ? ($positionData->parent) : 0;

            $data->setParent(null);
            if (intval($positionData->parent) > 0) {
                $data->setParent($entityManager->getReference($this->getEntityName(), $positionData->parent));
            }

            $menuItemRepo->persistAsFirstChild($data);
            if ($positionData->position) {
                $menuItemRepo->moveDown($data, $positionData->position);
            }

            $entityManager->flush();
        }
    }
}
