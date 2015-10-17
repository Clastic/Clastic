<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\CoreBundle\Module;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
interface ModuleInterface
{
    /**
     * The name of the module.
     *
     * @return string
     */
    public function getName();

    /**
     * The the unique identifier of the module.
     *
     * @return string
     */
    public function getIdentifier();
}
