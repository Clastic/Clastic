<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\TextBundle\Tests\Functional;

use Clastic\BackofficeBundle\Tests\ModuleWebTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group functional
 */
class TextModuleTest extends ModuleWebTestCase
{
    protected $listUrl = '/admin/text/list';
    protected $formUrl = '/admin/text/edit';
}
