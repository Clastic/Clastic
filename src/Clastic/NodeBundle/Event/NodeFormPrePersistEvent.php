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
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\Form;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeFormPrePersistEvent extends Event
{
    const NODE_FORM_PREPERSIST = 'clastic.node.form.prepersist';

    /**
     * @var Node
     */
    private $node;

    /**
     * @var Form
     */
    private $form;

    /**
     * @param Node $node
     * @param Form $form
     */
    public function __construct(Node $node, Form $form)
    {
        $this->node = $node;
        $this->form = $form;
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
}
