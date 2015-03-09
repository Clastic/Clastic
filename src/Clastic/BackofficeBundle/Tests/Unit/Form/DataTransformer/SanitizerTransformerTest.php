<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Tests\Unit\Form\DataTransformer;

use Clastic\BackofficeBundle\Form\DataTransformer\SanitizerTransformer;

/**
 * SanitizerTransformerTest
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group unit
 */
class SanitizerTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testTransform()
    {
        $transformer = new SanitizerTransformer();

        $this->assertEquals('value', $transformer->transform('value'));
    }

    public function testSanitizeScript()
    {
        $transformer = new SanitizerTransformer();

        $this->assertEquals('value', $transformer->reverseTransform('value<script>alert("test");</script>'));
    }

    public function testSanitizeOnClick()
    {
        $transformer = new SanitizerTransformer();

        $this->assertEquals(
            '<a href="url">link</a>',
            $transformer->reverseTransform('<a onclick="bla;" href="url">link</a>')
        );
    }
}
