<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\Tests\Unit\Form\Type;

use Clastic\BackofficeBundle\Form\Type\DatePickerType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Intl\Util\IntlTestHelper;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group functional
 */
class DatePickerTypeTest extends TypeTestCase
{
    private $defaultTimezone;

    protected function setUp()
    {
        parent::setUp();

        // we test against "de_AT", so we need the full implementation
        IntlTestHelper::requireFullIntl($this);

        \Locale::setDefault('de_AT');

        $this->defaultTimezone = date_default_timezone_get();
    }

    protected function tearDown()
    {
        date_default_timezone_set($this->defaultTimezone);
    }

    public function testThrowExceptionIfYearsIsInvalid()
    {
        $this->setExpectedException(InvalidOptionsException::class);

        $this->factory->create(new DatePickerType(), null, array(
            'years' => 'bad value',
        ));
    }

    public function testThrowExceptionIfMonthsIsInvalid()
    {
        $this->setExpectedException(InvalidOptionsException::class);

        $this->factory->create(new DatePickerType(), null, array(
            'months' => 'bad value',
        ));
    }

    public function testThrowExceptionIfDaysIsInvalid()
    {
        $this->setExpectedException(InvalidOptionsException::class);

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

    public function testParent()
    {
        $type = new DatePickerType();

        $this->assertEquals('date', $type->getParent());
    }
}
