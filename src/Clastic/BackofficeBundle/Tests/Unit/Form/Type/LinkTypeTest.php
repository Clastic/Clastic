<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\Tests\Unit\Form\Type;

use Clastic\BackofficeBundle\Form\Type\LinkType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group unit
 */
class LinkTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'label' => 'bla',
            'link' => 'link',
        );

        $type = new LinkType();
        $form = $this->factory->create($type);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function testParent()
    {
        $type = new LinkType();

        $this->assertEquals('form', $type->getParent());
    }
}
