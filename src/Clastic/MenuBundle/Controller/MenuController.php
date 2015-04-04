<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\MenuBundle\Controller;

use Clastic\BackofficeBundle\Controller\AbstractModuleController;
use Clastic\MenuBundle\Entity\Menu;
use Clastic\MenuBundle\Form\Type\MenuFormType;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Symfony\Component\Form\Form;

/**
 * MenuController
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class MenuController extends AbstractModuleController
{
    /**
     * @return string
     */
    protected function getType()
    {
        return 'menu';
    }

    /**
     * @return string
     */
    protected function getListTemplate()
    {
        return 'ClasticMenuBundle:Backoffice:list.html.twig';
    }

    /**
     * @param object $data
     *
     * @return Form
     */
    protected function buildForm($data)
    {
        return $this->createForm(new MenuFormType(), $data);
    }

    /**
     * @param object $data
     *
     * @return string
     */
    protected function resolveDataTitle($data)
    {
        return $data->getTitle();
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'ClasticMenuBundle:Menu';
    }

    /**
     * @param int $id
     *
     * @return NodeReferenceInterface
     */
    protected function resolveData($id)
    {
        if (!is_null($id)) {
            return $this->getDoctrine()->getRepository($this->getEntityName())
                ->find($id);
        }

        return new Menu();
    }
}
