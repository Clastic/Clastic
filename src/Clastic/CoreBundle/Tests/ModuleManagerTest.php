<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CoreBundle\Tests;

use Clastic\CoreBundle\Module\ModuleManager;
use Clastic\CoreBundle\Tests\Model\AdministrationModule;
use Clastic\CoreBundle\Tests\Model\ContentModule;
use Clastic\CoreBundle\Tests\Model\SubModule;

/**
 * ModuleManagerTest
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ModuleManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $manager = new ModuleManager();

        $this->assertEquals(array(), $manager->getModules());
        $this->assertEquals(array(), $manager->getContentModules());
        $this->assertEquals(array(), $manager->getAdministrationModules());
        $this->assertEquals(array(), $manager->getSubmodules('test'));
        $this->assertNull($manager->getModule('test'));
    }

    public function testContentFilter()
    {
        $manager = new ModuleManager();

        $adminModule = new AdministrationModule('admin');
        $manager->registerModule($adminModule);
        $manager->registerModule(new ContentModule('content'));
        $manager->registerModule(new SubModule('sub', 'test'));

        $this->assertEquals(array($adminModule), array_values($manager->getAdministrationModules()));
    }

    public function testAdminFilter()
    {
        $manager = new ModuleManager();

        $contentModule = new ContentModule('content');
        $manager->registerModule($contentModule);
        $manager->registerModule(new AdministrationModule('admin'));
        $manager->registerModule(new SubModule('sub', 'test'));

        $this->assertEquals(array($contentModule), array_values($manager->getContentModules()));
    }

    public function testSubModuleFilter()
    {
        $manager = new ModuleManager();

        $subModule = new SubModule('sub', 'parent');
        $manager->registerModule($subModule);
        $manager->registerModule(new AdministrationModule('admin'));
        $manager->registerModule(new ContentModule('content'));

        $this->assertEquals(array($subModule), array_values($manager->getSubmodules('parent')));
    }

    public function testGetModule()
    {
        $manager = new ModuleManager();

        $subModule = new SubModule('sub', 'test');
        $manager->registerModule($subModule);
        $manager->registerModule(new AdministrationModule('admin'));
        $manager->registerModule(new ContentModule('content'));

        $this->assertEquals($subModule, $manager->getModule('sub'));
    }

    public function testGetModules()
    {
        $manager = new ModuleManager();

        $manager->registerModule(new SubModule('sub', 'test'));
        $manager->registerModule(new AdministrationModule('admin'));
        $manager->registerModule(new ContentModule('content'));

        $this->assertCount(3, $manager->getModules());
    }
}
