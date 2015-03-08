<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Tests\Unit\Form\Type;

use Clastic\AliasBundle\Form\Type\AliasType;
use Clastic\BackofficeBundle\Form\Type\DatePickerType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group functional
 */
class DatePickerTypeTest extends TypeTestCase
{
    public function testThrowExceptionIfYearsIsInvalid()
    {
        $this->setExpectedException('Symfony\Component\OptionsResolver\Exception\InvalidOptionsException');

        $this->factory->create(new DatePickerType(), null, array(
            'years' => 'bad value',
        ));
    }

    public function testThrowExceptionIfMonthsIsInvalid()
    {
        $this->setExpectedException('Symfony\Component\OptionsResolver\Exception\InvalidOptionsException');

        $this->factory->create(new DatePickerType(), null, array(
            'months' => 'bad value',
        ));
    }

    public function testThrowExceptionIfDaysIsInvalid()
    {
        $this->setExpectedException('Symfony\Component\OptionsResolver\Exception\InvalidOptionsException');

        $this->factory->create(new DatePickerType(), array(), array(
            'days' => 'bad value',
        ));
    }

    public function testSubmitFromSingleTextString()
    {
        $form = $this->factory->create(new DatePickerType());

        $form->submit('2.6.2010');

        $this->assertEquals('2.6.2010', $form->getViewData());
    }
}
