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
     * Get all modules.
     *
     * @return ModuleInterface[]
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Get all modules that handle content.
     *
     * @return ModuleInterface[]
     */
    public function getContentModules()
    {
        return array_filter($this->getModules(), function (ModuleInterface $module) {
            return !($module instanceof AdministrationModuleInterface)
                && !($module instanceof SubmoduleInterface);
        });
    }

    /**
     * Get all modules that handle administration.
     *
     * @return ModuleInterface[]
     */
    public function getAdministrationModules()
    {
        return array_filter($this->getModules(), function (ModuleInterface $module) {
            return $module instanceof AdministrationModuleInterface;
        });
    }

    /**
     * @param string $mainIdentifier
     *
     * @return SubmoduleInterface[]
     */
    public function getSubmodules($mainIdentifier)
    {
        return array_filter($this->getModules(), function (ModuleInterface $module) use ($mainIdentifier) {
            return ($module instanceof SubmoduleInterface)
                && $module->getParentIdentifier() == $mainIdentifier;
        });
    }

    /**
     * @param string $name
     *
     * @return ModuleInterface|null
     */
    public function getModule($name)
    {
        if (isset($this->modules[$name])) {
            return $this->modules[$name];
        }

        return;
    }
}
