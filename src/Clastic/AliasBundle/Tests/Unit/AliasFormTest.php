<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\AliasBundle\Tests\Unit;

use Clastic\AliasBundle\Entity\Alias;
use Clastic\AliasBundle\Form\AliasType;
use Clastic\BackofficeBundle\Form\Type\TabsTabActionsType;
use Clastic\BackofficeBundle\Form\Type\TabsTabType;
use Clastic\BackofficeBundle\Form\Type\TabsType;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group functional
 */
class AliasModuleTest extends TypeTestCase
{
    protected function getExtensions()
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request());

        $tabsType = new TabsType();
        $tabsTabType = new TabsTabType();
        $tabsTabActionType = new TabsTabActionsType();
        $aliasType = new \Clastic\AliasBundle\Form\Type\AliasType($requestStack);

        return array(new PreloadedExtension(array(
            $tabsType->getName() => $tabsType,
            $tabsTabType->getName() => $tabsTabType,
            $tabsTabActionType->getName() => $tabsTabActionType,
            $aliasType->getName() => $aliasType,
        ), array()));
    }

    public function testFormAlias()
    {
        $formData = array(
            'tabs' => array(
                'general' => array(
                    'alias' => 'testAlias',
                ),
            ),
        );


        $type = new AliasType();
        $form = $this->factory->create($type, new Alias());


        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $alias = new Alias();
        $alias->setAlias('testAlias');

        $this->assertEquals($alias, $form->getData());
    }

    public function testFormEmpty()
    {
        $formData = array();

        $type = new AliasType();
        $form = $this->factory->create($type, new Alias());


        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $alias = new Alias();

        $this->assertEquals($alias, $form->getData());
    }
}
