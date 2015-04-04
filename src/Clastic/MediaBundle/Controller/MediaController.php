<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\MediaBundle\Controller;

use Clastic\BackofficeBundle\Controller\AbstractModuleController;
use Clastic\MediaBundle\Entity\File;
use Clastic\MediaBundle\Form\Type\FileFormType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * MenuController
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class MediaController extends AbstractModuleController
{
    /**
     * @return string
     */
    protected function getType()
    {
        return 'media';
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        $this->buildBreadcrumbs($this->getType());

        $file = new File();
        $form = $this->createForm(new FileFormType(), $file);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($file);
            $em->flush();

            return $this->redirect($this->generateUrl('clastic_node_list', array(
                'type' => $this->getType(),
            )));
        }

        return $this->render('ClasticMediaBundle:Backoffice:list.html.twig', array(
            'form' => $form->createView(),
            'type' => $this->getType(),
            'module' => $this->get('clastic.module_manager')->getModule($this->getType()),
        ));
    }

    /**
     * @param int|null $id
     *
     * @return mixed
     */
    protected function resolveData($id)
    {
        return null;
    }

    /**
     * @return string
     */
    protected function getListTemplate()
    {
        return null;
    }

    /**
     * @param object $data
     *
     * @return Form
     */
    protected function buildForm($data)
    {
        return null;
    }

    /**
     * @param object $data
     *
     * @return string
     */
    protected function resolveDataTitle($data)
    {
        return null;
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return null;
    }
}
