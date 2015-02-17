<?php

namespace Clastic\BlogBundle\Entity;

use Clastic\TaxonomyBundle\Model\Taxonomy;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class Category extends Taxonomy
{
    /**
     * @var ArrayCollection
     */
    private $blogs;

    public function __construct()
    {
        $this->news = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getBlogs()
    {
        return $this->blogs;
    }

    /**
     * @param ArrayCollection $blogs
     */
    public function setBlogs(ArrayCollection $blogs)
    {
        $this->blogs = $blogs;
    }
}
