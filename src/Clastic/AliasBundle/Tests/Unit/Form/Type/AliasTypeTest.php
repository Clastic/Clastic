<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\AliasBundle\Tests\Unit\Form\Type;

use Clastic\AliasBundle\Form\Type\AliasType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group functional
 */
class AliasTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = 'alias';

        $requestStack = new RequestStack();
        $requestStack->push(new Request());

        $type = new AliasType($requestStack);
        $form = $this->factory->create($type);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData, $form->getData());
    }
}
