<?php

namespace Clastic\TaxonomyBundle\Model;

use Clastic\NodeBundle\Entity\Node;
use Clastic\NodeBundle\Node\NodeReferenceInterface;

/**
 * Taxonomy.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
abstract class Taxonomy implements NodeReferenceInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var Node
     */
    protected $node;

    /**
     */
    protected $left;

    /**
     */
    protected $level;

    /**
     */
    protected $right;

    /**
     */
    protected $root;

    /**
     */
    protected $parent;

    /**
     */
    protected $children;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Taxonomy
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * @return Taxonomy
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Taxonomy $parent
     */
    public function setParent(Taxonomy $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * @return Taxonomy[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Taxonomy[] $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }
}
