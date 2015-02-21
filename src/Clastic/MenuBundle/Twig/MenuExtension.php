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

    /**
     * @param MenuItemRepository $repository
     */
    public function __construct(MenuItemRepository $repository)
    {
        $this->repo = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('clastic_menu', array($this, 'renderMenu'), array('is_safe' => array('html'))),
        );
    }

    /**
     * @param string $menuIdentifier
     * @param int    $depth
     *
     * @return string
     */
    public function renderMenu($menuIdentifier, $depth = 1)
    {
        $qb = $this->repo->getNodesHierarchyQueryBuilder(null, false, array(), true)
            ->join('ClasticMenuBundle:Menu', 'menu', 'menu.id = node.menu')
            ->andWhere('menu.identifier = :identifier')
            ->setParameter('identifier', $menuIdentifier);

        $globals = $this->environment->getGlobals();
        $currentUrl = $globals['app']->getRequest()->server->get('REQUEST_URI');

        $items = array_map(function(MenuItem $item) use ($currentUrl) {

            $url = $item->getUrl();
            $node = $item->getNode();
            // TODO Remove getTitle once a solution is found.
            if ($node && $node->getTitle() && isset($node->alias)) {
                $url = '/' . $node->alias->getAlias();
            }

            return array(
                'title' => $item->getTitle(),
                'left' => $item->getLeft(),
                'right' => $item->getRight(),
                'root' => $item->getRoot(),
                'level' => $item->getLevel(),
                'id' => $item->getId(),
                '_node' => $item,
                '_active' => ($url == $currentUrl),
                '_link' => $url,
            );
        }, $qb->getQuery()->getResult());

        return $this->environment->render('ClasticMenuBundle:Twig:menu.html.twig', array(
            'tree' => $this->repo->buildTree($items),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'clastic_menu';
    }
}