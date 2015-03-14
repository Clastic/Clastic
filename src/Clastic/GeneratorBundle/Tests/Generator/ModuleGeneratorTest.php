<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\GeneratorBundle\Tests\Generator;

use Clastic\GeneratorBundle\Generator\ModuleGenerator;
use Sensio\Bundle\GeneratorBundle\Tests\Generator\GeneratorTest;

/**
 * ModuleGeneratorTest
 */
class ModuleGeneratorTest extends GeneratorTest
{
    public function testGenerateController()
    {
        mkdir($this->tmpDir . '/Resources/config/', 0777, true);
        copy(__DIR__ . '/../Stubs/services_empty.xml', $this->tmpDir . '/Resources/config/services.xml');
        $this->getGenerator()->generate($this->getBundle(), 'Test', 'ClasticBlogBundle:Blog ');


        $files = array(
            'Module/TestModule.php',
            'Form/Module/TestFormExtension.php',
        );
        foreach ($files as $file) {
            $this->assertTrue(file_exists($this->tmpDir.'/'.$file), sprintf('%s has been generated', $file));
        }

        $content = file_get_contents($this->tmpDir.'/Module/TestModule.php');
        $strings = array(
            'namespace Foo\\BarBundle\\Module',
            'class TestModule',
        );
        foreach ($strings as $string) {
            $this->assertContains($string, $content);
        }

        $content = file_get_contents($this->tmpDir.'/Form/Module/TestFormExtension.php');
        $strings = array(
            'namespace Foo\\BarBundle\\Form\\Module',
            'class TestFormExtension',
        );
        foreach ($strings as $string) {
            $this->assertContains($string, $content);
        }
    }

    public function testGeneratedXml()
    {
        mkdir($this->tmpDir . '/Resources/config/', 0777, true);
        copy(__DIR__ . '/../Stubs/services_empty.xml', $this->tmpDir . '/Resources/config/services.xml');
        $this->getGenerator()->generate($this->getBundle(), 'Test', 'ClasticBlogBundle:Blog ');

        $xml = <<<EOL
<?xml version="1.0" ?>

<container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">

    <parameters>
        <parameter key="foo_bar_bundle.test.module.class">Foo\BarBundle\Module\TestModule</parameter>
        <parameter key="foo_bar_bundle.test.module.form_extension.class">Foo\BarBundle\Form\Module\TestFormExtension</parameter>
    </parameters>
    <services>
        <service id="foo_bar_bundle.test.module" class="%foo_bar_bundle.test.module.class%">
            <tag name="clastic.module" node_module="true" alias="test"/>
            <tag name="clastic.node_form" build_service="foo_bar_bundle.test.module.form_extension"/>
        </service>
        <service id="foo_bar_bundle.test.module.form_extension" class="%foo_bar_bundle.test.module.form_extension.class%"/>
    </services>
</container>
EOL;

        $this->assertXmlStringEqualsXmlString($xml, file_get_contents($this->tmpDir . '/Resources/config/services.xml'));
    }

    public function testGeneratedXmlContainer()
    {
        mkdir($this->tmpDir . '/Resources/config/', 0777, true);
        copy(__DIR__ . '/../Stubs/services_containers.xml', $this->tmpDir . '/Resources/config/services.xml');
        $this->getGenerator()->generate($this->getBundle(), 'Test', 'ClasticBlogBundle:Blog ');

        $xml = <<<EOL
<?xml version="1.0" ?>

<container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">

    <parameters>
        <parameter key="something">value</parameter>
        <parameter key="foo_bar_bundle.test.module.class">Foo\BarBundle\Module\TestModule</parameter>
        <parameter key="foo_bar_bundle.test.module.form_extension.class">Foo\BarBundle\Form\Module\TestFormExtension</parameter>
    </parameters>
    <services>
        <service class="someclass" id="bla"/>
        <service id="foo_bar_bundle.test.module" class="%foo_bar_bundle.test.module.class%">
            <tag name="clastic.module" node_module="true" alias="test"/>
            <tag name="clastic.node_form" build_service="foo_bar_bundle.test.module.form_extension"/>
        </service>
        <service id="foo_bar_bundle.test.module.form_extension" class="%foo_bar_bundle.test.module.form_extension.class%"/>
    </services>
</container>
EOL;

        $this->assertXmlStringEqualsXmlString($xml, file_get_contents($this->tmpDir . '/Resources/config/services.xml'));
    }

    protected function getGenerator()
    {
        $generator = new ModuleGenerator($this->filesystem);
        $generator->setSkeletonDirs(__DIR__.'/../../Resources/SensioGeneratorBundle/skeleton');

        return $generator;
    }

    protected function getBundle()
    {
        $bundle = $this->getMock('Symfony\Component\HttpKernel\Bundle\BundleInterface');
        $bundle->expects($this->any())->method('getPath')->will($this->returnValue($this->tmpDir));
        $bundle->expects($this->any())->method('getName')->will($this->returnValue('FooBarBundle'));
        $bundle->expects($this->any())->method('getNamespace')->will($this->returnValue('Foo\BarBundle'));

        return $bundle;
    }
}
