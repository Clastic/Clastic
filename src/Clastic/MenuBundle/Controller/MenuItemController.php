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
use Clastic\MenuBundle\Form\MenuItemType;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * MenuItemController
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
        return $this->createForm(new MenuItemType(), $data);
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
     * @return Response
     */
    public function listAction($menuId = null)
    {
        $this->menuId = $menuId;

        return parent::listAction();
    }

    public function deleteAction($id, Request $request, $menuId = null)
    {
        $this->menuId = $menuId;

        return parent::deleteAction($id, $request);
    }

    /**
     * @param QueryBuilder $qb
     *
     * @return QueryBuilder
     */
    protected function alterListQuery(QueryBuilder $qb)
    {
//        $qb->andWhere('e.menu = :menu');
//        $qb->setParameter('menu', 'bla');
//
        return $qb;
    }

    public function formAction($id, Request $request, $menuId = null)
    {
        $this->menuId = $menuId;

        return parent::formAction($id, $request);
    }

    protected function getExtraListVariables()
    {
        return array(
            'menuId' => $this->menuId,
        );
    }

    protected function getFormSuccessUrl($data)
    {
        return $this->generateUrl('clastic_backoffice_menu_item_form', array(
            'menuId' => $this->menuId,
            'id' => $data->getId(),
        ));
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
        $breadcrumbs = parent::buildBreadcrumbs($type);

        $breadcrumbs->addItem($this->getCurrentMenu()->getTitle(), $this->get("router")->generate("clastic_backoffice_menu_form", array(
            'id' => $this->menuId,
        )));

        $breadcrumbs->addItem('Items', $this->get("router")->generate("clastic_backoffice_menu_item_list", array(
            'menuId' => $this->menuId,
        )));

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
}
