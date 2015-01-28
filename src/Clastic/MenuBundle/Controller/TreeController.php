<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\MenuBundle\Controller;

use Clastic\MenuBundle\Entity\Menu;
use Clastic\MenuBundle\Entity\MenuItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * MenuController
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class TreeController extends Controller
{
    /**
     * @param Request    $request
     * @param int|string $menuId
     *
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function ajaxAction(Request $request, $menuId)
    {
        $id = $request->query->get('id');
        $currentId = $request->query->get('currentId');

        $em = $this->getDoctrine()->getEntityManager();
        $filter = array(
            'menu' => $em->getReference('ClasticMenuBundle:Menu', $menuId),
            'parent' => null,
        );

        if (intval($id)) {
            $filter['parent'] = $em->getReference('ClasticMenuBundle:MenuItem', (int) $request->query->get('id'));
        }

        $items = $this->getDoctrine()
            ->getRepository('ClasticMenuBundle:MenuItem')
            ->findBy($filter);

        $data = array_map(function(MenuItem $item) use ($currentId) {
            return array(
                'id' => $item->getId(),
                'text' => $item->getTitle(),
                'children' => true,
                'state' => array(
                    'disabled' => ($item->getId() != $currentId),
                ),
            );
        }, $items);

        if (!$currentId && is_null($filter['parent'])) {
            $data[] = array(
                'id' => 'current',
                'text' => 'New Item',
                'children' => false,
                'state' => array(
                    'disabled' => false,
                ),
            );
        }

        return new JsonResponse($data);
    }
}
