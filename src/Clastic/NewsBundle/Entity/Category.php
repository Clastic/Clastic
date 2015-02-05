<?php

namespace Clastic\NewsBundle\Entity;

use Clastic\NodeBundle\Entity\Node;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class Category implements NodeReferenceInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Node
     */
    private $node;

    /**
     * @var ArrayCollection
     */
    private $news;

    /**
     */
    private $left;

    /**
     */
    private $level;

    /**
     */
    private $right;

    /**
     */
    private $root;

    /**
     */
    private $parent;

    /**
     */
    private $children;

    public function __construct()
    {
        $this->news = new ArrayCollection();
    }

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
     * Set description
     *
     * @param string $description
     *
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
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
     * @return ArrayCollection
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * @param ArrayCollection $news
     */
    public function setNews(ArrayCollection $news)
    {
        $this->news = $news;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     */
    public function setParent(Category $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * @return Category[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Category[] $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }
}
