<?php

namespace Clastic\NewsBundle\Entity;

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
    private $news;

    public function __construct()
    {
        $this->news = new ArrayCollection();
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
}
