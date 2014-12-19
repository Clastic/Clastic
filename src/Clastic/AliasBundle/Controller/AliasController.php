<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\AliasBundle\Controller;

use Clastic\AliasBundle\Entity\Alias;
use Clastic\AliasBundle\Form\AliasType;
use Clastic\CoreBundle\Entity\Node;
use Clastic\CoreBundle\Node\NodeManager;
use Clastic\CoreBundle\Node\NodeReferenceInterface;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * NodeController
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class AliasController extends Controller
{
    /**
     * @return Response
     */
    public function listAction()
    {
        $queryBuilder = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('e')
            ->from('ClasticAliasBundle:Alias', 'e')
            ->orderBy('e.id', 'DESC');

        $adapter = new DoctrineORMAdapter($queryBuilder);
        $data = new Pagerfanta($adapter);

        return $this->render('ClasticAliasBundle:Backoffice:list.html.twig', array(
            'data' => $data,
            'type' => 'alias',
            'module' => $this->get('clastic.module_manager')->getModule('alias'),
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
        $form = $this->createForm(new AliasType(), $data);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $this->persistData($data);

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Your changes were saved!');

            return $this->redirect($this->generateUrl('clastic_backoffice_form', array(
                'type' => 'alias',
                'nodeId' => $data->getNode()->getId(),
            )));
        }

        return $this->render('ClasticBackofficeBundle:Node:form.html.twig', array(
            'form' => $form->createView(),
            'module' => $this->get('clastic.module_manager')->getModule('alias'),
        ));
    }
    /**
     * @param int    $id
     *
     * @return NodeReferenceInterface
     */
    private function resolveData($id)
    {
        if (!is_null($id)) {
            return $this->getDoctrine()->getRepository('ClasticAliasBundle:Alias')
                ->find($id);
        }

        return new Alias();
    }
    /**
     * @param Alias $data
     */
    private function persistData($data)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
    }
}
