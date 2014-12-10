<?php
/**
 * This file is part of the Backend package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CoreBundle\Module;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ModuleManager
{
    /**
     * @var ModuleInterface[]
     */
    private $modules;

    public function __construct()
    {
        $this->modules = array();
    }

    /**
     * @param ModuleInterface $module
     */
    public function registerModule(ModuleInterface $module)
    {
        $this->modules[$module->getIdentifier()] = $module;
    }

    /**
     * @return ModuleInterface[]
     */
    public function getModules()
    {
        return $this->modules;
    }

    public function getModule($name)
    {
        if (isset($this->modules[$name])) {
            return $this->modules[$name];
        }

        return null;
    }
}
 