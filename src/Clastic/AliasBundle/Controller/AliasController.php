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
use Clastic\BackofficeBundle\Controller\AbstractModuleController;
use Clastic\CoreBundle\Entity\Node;
use Clastic\CoreBundle\Node\NodeReferenceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;

/**
 * NodeController
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class AliasController extends AbstractModuleController
{
    /**
     * @return string
     */
    protected function getType()
    {
        return 'alias';
    }

    /**
     * @return string
     */
    protected function getListTemplate()
    {
        return 'ClasticAliasBundle:Backoffice:list.html.twig';
    }

    /**
     * @param object $data
     *
     * @return Form
     */
    protected function buildForm($data)
    {
        return $this->createForm(new AliasType(), $data);
    }

    /**
     * @param object $data
     *
     * @return string
     */
    protected function resolveDataTitle($data)
    {
        return $data->getNode()->getTitle();
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'ClasticAliasBundle:Alias';
    }

    /**
     * @param int $id
     *
     * @return NodeReferenceInterface
     */
    protected function resolveData($id)
    {
        if (!is_null($id)) {
            return $this->getDoctrine()->getRepository('ClasticAliasBundle:Alias')
                ->find($id);
        }

        return new Alias();
    }
}
