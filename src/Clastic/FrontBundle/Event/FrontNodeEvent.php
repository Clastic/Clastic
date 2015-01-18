<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\FrontBundle\Event;

use Clastic\NodeBundle\Entity\Node;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class FrontNodeEvent extends Event
{
    /**
     * @var Node
     */
    private $node;

    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $templateArguments;

    /**
     * @param Node    $node
     * @param string  $template
     * @param array   $templateArguments
     * @param Request $request
     */
    public function __construct(Node $node, $template, array $templateArguments, Request $request)
    {
        $this->node = $node;
        $this->template = $template;
        $this->templateArguments = $templateArguments;
    }

    /**
     * @return Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return array
     */
    public function getTemplateArguments()
    {
        return $this->templateArguments;
    }

    /**
     * @param array $templateArguments
     */
    public function setTemplateArguments(array $templateArguments)
    {
        $this->templateArguments = $templateArguments;
    }
}
