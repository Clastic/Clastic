<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BlockBundle\Controller;

use Clastic\BackofficeBundle\Controller\AbstractModuleController;
use Clastic\BlockBundle\Entity\Block;
use Clastic\BlockBundle\Form\Type\BlockFormType;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Symfony\Component\Form\Form;

/**
 * BlockController.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class BlockController extends AbstractModuleController
{
    /**
     * @return string
     */
    protected function getType()
    {
        return 'block';
    }

    /**
     * @return string
     */
    protected function getListTemplate()
    {
        return 'ClasticBlockBundle:Backoffice:list.html.twig';
    }

    /**
     * @param object $data
     *
     * @return Form
     */
    protected function buildForm($data)
    {
        return $this->createForm(BlockFormType::class, $data);
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
        return 'ClasticBlockBundle:Block';
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

        return new Block();
    }
}
