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
use Clastic\UserBundle\Entity\Group;
use Clastic\UserBundle\Form\Type\GroupFormType;
use Symfony\Component\Form\Form;

/**
 * GroupController.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class GroupController extends AbstractModuleController
{
    /**
     * @return string
     */
    protected function getType()
    {
        return 'user_group';
    }

    /**
     * @return string
     */
    protected function getListTemplate()
    {
        return 'ClasticUserBundle:Backoffice:group_list.html.twig';
    }

    /**
     * @param Group $data
     *
     * @return Form
     */
    protected function buildForm($data)
    {
        return $this->createForm(new GroupFormType(), $data);
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'ClasticUserBundle:Group';
    }

    /**
     * @param Group $data
     *
     * @return string
     */
    protected function resolveDataTitle($data)
    {
        if (!$data->getId()) {
            return 'New';
        }

        return $data->getName();
    }

    /**
     * @param int $id
     *
     * @return Group
     */
    protected function resolveData($id)
    {
        if (!is_null($id)) {
            return $this->getDoctrine()->getRepository('ClasticUserBundle:Group')
                ->find($id);
        }

        return new Group('');
    }
}
