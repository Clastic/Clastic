<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class Group extends BaseGroup
{
    function __toString()
    {
        return $this->getName();
    }
}
