<?php

namespace Clastic\NodeBundle\Entity;

/**
 * NodePublication
 */
class NodePublication
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $available;

    /**
     * @var \DateTime
     */
    private $publishedFrom;

    /**
     * @var \DateTime
     */
    private $publishedTill;

    /**
     * Set the default publication to true.
     */
    public function __construct()
    {
        $this->available = true;
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
     * Set available
     *
     * @param boolean $available
     *
     * @return NodePublication
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return boolean
     */
    public function isAvailable()
    {
        return $this->available;
    }

    /**
     * Set publishedFrom
     *
     * @param \DateTime $publishedFrom
     *
     * @return NodePublication
     */
    public function setPublishedFrom($publishedFrom)
    {
        $this->publishedFrom = $publishedFrom;

        return $this;
    }

    /**
     * Get publishedFrom
     *
     * @return \DateTime
     */
    public function getPublishedFrom()
    {
        return $this->publishedFrom;
    }

    /**
     * Set publishedTill
     *
     * @param \DateTime $publishedTill
     *
     * @return NodePublication
     */
    public function setPublishedTill($publishedTill)
    {
        $this->publishedTill = $publishedTill;

        return $this;
    }

    /**
     * Get publishedTill
     *
     * @return \DateTime
     */
    public function getPublishedTill()
    {
        return $this->publishedTill;
    }

    /**
     * @return bool
     */
    public function isOnline()
    {
        $now = new \DateTime();

        return $this->available
            && $this->publishedFrom <= $now
            && (is_null($this->publishedTill) || $this->publishedTill >= $now);
    }
}
