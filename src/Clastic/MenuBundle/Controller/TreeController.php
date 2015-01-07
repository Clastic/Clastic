<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\MenuBundle\Controller;

use Clastic\AliasBundle\Form\AliasType;
use Clastic\BackofficeBundle\Controller\AbstractModuleController;
use Clastic\MenuBundle\Entity\Menu;
use Clastic\MenuBundle\Entity\MenuItem;
use Clastic\MenuBundle\Form\MenuType;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
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
        );

        if (intval($id)) {
            $filter['parent'] = $em->getReference('ClasticMenuBundle:MenuItem', (int) $request->query->get('id'));
        }
        else {
            $filter['parent'] = null;
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

        return new JsonResponse($data);
    }
}
