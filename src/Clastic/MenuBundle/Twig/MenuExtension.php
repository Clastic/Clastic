<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\MenuBundle\Twig;

use Clastic\MenuBundle\Entity\Menu;
use Clastic\MenuBundle\Entity\MenuItem;
use Clastic\MenuBundle\Entity\MenuItemRepository;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class MenuExtension extends \Twig_Extension
{
    /**
     * @var \Twig_Environment
     */
    private $environment;

    /**
     * @var MenuItemRepository
     */
    private $repo;

    public function __construct(MenuItemRepository $repository)
    {
        $this->repo = $repository;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('clastic_menu', array($this, 'renderMenu'), array('is_safe' => array('html'))),
        );
    }

    public function renderMenu($menuId, $depth = 1)
    {
        $qb = $this->repo->getNodesHierarchyQueryBuilder(null, false, array(), true)
            ->andWhere('node.menu = :menu')
            ->setParameter('menu', $menuId);

        $globals = $this->environment->getGlobals();
        $url = $globals['app']->getRequest()->server->get('REQUEST_URI');

        $items = array_map(function(MenuItem $item) use ($url) {
            return array(
                'title' => $item->getTitle(),
                'left' => $item->getLeft(),
                'right' => $item->getRight(),
                'root' => $item->getRoot(),
                'level' => $item->getLevel(),
                'id' => $item->getId(),
                '_node' => $item,
                '_active' => ('/' . $item->getNode()->alias->getAlias() == $url),
                '_link' => $item->getNode()->alias->getAlias(),
            );
        }, $qb->getQuery()->getResult());

        return $this->environment->render('ClasticMenuBundle:Twig:menu.html.twig', array(
            'tree' => $this->repo->buildTree($items),
        ));
    }

    public function getName()
    {
        return 'clastic_menu';
    }
}
