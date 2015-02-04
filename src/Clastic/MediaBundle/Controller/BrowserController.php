<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\MediaBundle\Controller;

use Clastic\AliasBundle\Form\AliasType;
use Clastic\BackofficeBundle\Controller\AbstractModuleController;
use Clastic\MediaBundle\Entity\Directory;
use Clastic\MediaBundle\Entity\File;
use Clastic\MenuBundle\Entity\Menu;
use Clastic\MenuBundle\Entity\MenuItem;
use Clastic\MenuBundle\Form\MenuType;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * BrowserController handles all ajax calls for the file browser.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class BrowserController extends Controller
{
    /**
     * Get all directories.
     *
     * @param Request    $request
     *
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function directoryAction(Request $request)
    {
        $id = $request->query->get('id');

        $parent = null;
        if (intval($id)) {
            $em = $this->getDoctrine()->getManager();

            $parent = $em->getReference('ClasticMediaBundle:Directory', $id);
        }

        $directories = $this->getDoctrine()->getRepository('ClasticMediaBundle:Directory')
            ->findBy(array(
                'parent' => $parent,
            ));

        $data = array_map(function(Directory $directory) use ($parent) {
            return array(
                'id' => $directory->getId(),
                'text' => $directory->getName(),
                'children' => true,
                'state' => array(
                    'disabled' => false,
                    'opened' => !$parent,
                    'selected' => !$parent,
                ),
            );
        }, $directories);

        return new JsonResponse($data);
    }

    /**
     * Get all files is a specific folder.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function filesAction(Request $request)
    {
        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();

        $files = $this->getDoctrine()->getRepository('ClasticMediaBundle:File')
            ->findBy(array(
                'directory' => $em->getReference('ClasticMediaBundle:Directory', $id),
            ));

        $data = array_map(function(File $file) {
            return array(
                'id' => $file->getId(),
                'text' => $file->getName(),
                'path' => '/uploads/documents/' . $file->getPath(),
            );
        }, $files);

        return new JsonResponse($data);
    }
}
