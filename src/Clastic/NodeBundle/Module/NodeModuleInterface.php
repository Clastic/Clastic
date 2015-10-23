<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\NodeBundle\Module;

use Clastic\CoreBundle\Module\ModuleInterface;

/**
 * NodeModuleInterface.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
interface NodeModuleInterface extends ModuleInterface
{
    /**
     * @return string
     */
    public function getEntityName();

    /**
     * @return string|bool
     */
    public function getDetailTemplate();
}
