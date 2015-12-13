<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\AliasBundle\Tests\Unit\Form\Type;

use Clastic\AliasBundle\Form\Extension\AliasExtension;
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
    private $requestStack;

    protected function setUp()
    {
        $this->requestStack = new RequestStack();
        $this->requestStack->push(new Request());

        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->requestStack = null;
    }

    protected function getExtensions()
    {
        return array_merge(parent::getExtensions(), array(
            new AliasExtension($this->requestStack),
        ));
    }

    public function testSubmitValidData()
    {
        $formData = 'alias';
        $form = $this->factory->create(AliasType::class);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData, $form->getData());
    }
}
