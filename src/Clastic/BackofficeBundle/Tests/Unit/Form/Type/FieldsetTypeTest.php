<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\Tests\Unit\Form\Type;

use Clastic\BackofficeBundle\Form\Type\FieldsetType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group unit
 */
class FieldsetTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array();

        $form = $this->factory->create(FieldsetType::class);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
    }

    public function testParent()
    {
        $type = new FieldsetType();

        $this->assertEquals(FormType::class, $type->getParent());
    }
}
