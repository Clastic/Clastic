<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\UserBundle\Controller;

use Clastic\BackofficeBundle\Controller\AbstractModuleController;
use Clastic\UserBundle\Entity\User;
use Clastic\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;

/**
 * NodeController
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class UserController extends AbstractModuleController
{
    /**
     * @return string
     */
    protected function getType()
    {
        return 'user';
    }

    /**
     * @return string
     */
    protected function getListTemplate()
    {
        return 'ClasticUserBundle:Backoffice:list.html.twig';
    }

    /**
     * @param User $data
     *
     * @return Form
     */
    protected function buildForm($data)
    {
        return $this->createForm(new UserType(is_null($data->getId())), $data);
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'ClasticUserBundle:User';
    }

    /**
     * @param User $data
     *
     * @return string
     */
    protected function resolveDataTitle($data)
    {
        if (!$data->getId()) {
            return 'New';
        }

        return $data->getUsername();
    }

    /**
     * @param int $id
     *
     * @return User
     */
    protected function resolveData($id)
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
    protected function persistData($data)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $userManager->updateUser($data);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
    }
}
