<?php

namespace Clastic\TextBundle\Entity;

use Clastic\CoreBundle\Entity\Node;
use Clastic\CoreBundle\Node\NodeReferenceInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Text
 */
class Text implements NodeReferenceInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Node
     */
    private $node;

    /**
     * @var string
     */
    private $body;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @param Node $node
     */
    public function setNode(Node $node)
    {
        $this->node = $node;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Text
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }
}
