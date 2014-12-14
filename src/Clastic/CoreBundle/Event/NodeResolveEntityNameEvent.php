<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeResolveEntityNameEvent extends Event
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $entityName;

    /**
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * @param string $entityName
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
    }
}
