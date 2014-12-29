<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\UserBundle\Controller;

use Clastic\AliasBundle\Entity\Alias;
use Clastic\AliasBundle\Form\AliasType;
use Clastic\CoreBundle\Entity\Node;
use Clastic\CoreBundle\Node\NodeManager;
use Clastic\CoreBundle\Node\NodeReferenceInterface;
use Clastic\UserBundle\Entity\User;
use Clastic\UserBundle\Form\UserType;
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
class UserController extends Controller
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
            ->from('ClasticUserBundle:User', 'e')
            ->orderBy('e.id', 'DESC');

        $adapter = new DoctrineORMAdapter($queryBuilder);
        $data = new Pagerfanta($adapter);

        return $this->render('ClasticUserBundle:Backoffice:list.html.twig', array(
            'data' => $data,
            'type' => 'user',
            'module' => $this->get('clastic.module_manager')->getModule('user'),
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

        $form = $this->createForm(new UserType(is_null($data->getId())), $data);


        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $this->persistData($data);

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Your changes were saved!');

            return $this->redirect($this->generateUrl('clastic_backoffice_form', array(
                'type' => 'user',
                'nodeId' => $data->getId(),
            )));
        }

        return $this->render('ClasticBackofficeBundle:Node:form.html.twig', array(
            'form' => $form->createView(),
            'module' => $this->get('clastic.module_manager')->getModule('user'),
        ));
    }

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function deleteAction($id, Request $request)
    {
        $data = $this->resolveData($id);
        $title = $data->getUsername();

        $em = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success', sprintf('Your deleted "%s"!', $title));

        return $this->redirect($this->generateUrl('clastic_backoffice_list', array(
            'type' => 'user',
            'module' => $this->get('clastic.module_manager')->getModule('user'),
        )));
    }

    /**
     * @param int    $id
     *
     * @return User
     */
    private function resolveData($id)
    {
        if (!is_null($id)) {
            return $this->getDoctrine()->getRepository('ClasticUserBundle:User')
                ->find($id);
        }

        $user = new User();

        $user->setPlainPassword(rand());

        return $user;
    }
    /**
     * @param User $data
     */
    private function persistData($data)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $userManager->updateUser($data);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
    }
}
