<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NodeBundle\Event;

use Clastic\NodeBundle\Entity\Node;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\Form;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeFormPersistEvent extends Event
{
    const NODE_FORM_PERSIST = 'clastic.node.form.persist';

    /**
     * @var Node
     */
    private $node;

    /**
     * @var Form
     */
    private $form;

    /**
     * @var EntityManager
     */
    private $em;


    /**
     * @param Node          $node
     * @param Form          $form
     * @param EntityManager $em
     */
    public function __construct(Node $node, Form $form, EntityManager $em)
    {
        $this->node = $node;
        $this->form = $form;
        $this->em = $em;
    }

    /**
     * @return Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }
}
