<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\TaxonomyBundle\Controller;

use Clastic\TaxonomyBundle\Model\Taxonomy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * TreeController
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class TreeController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function ajaxAction(Request $request)
    {
        $id = $request->query->get('id');
        $entityName = $request->query->get('entityName');
        $currentId = $request->query->get('currentId');

        $em = $this->getDoctrine()->getManager();
        $filter = array(
            'parent' => null,
        );

        if (intval($id)) {
            $filter['parent'] = $em->getReference($entityName, (int) $request->query->get('id'));
        }

        $items = $this->getDoctrine()
            ->getRepository($entityName)
            ->findBy($filter);

        $data = array_map(function(Taxonomy $item) use ($currentId) {
            return array(
                'id' => $item->getId(),
                'text' => $item->getNode()->getTitle(),
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
