<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BlockBundle\Tests\Functional;

use Clastic\BackofficeBundle\Tests\ModuleWebTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group functional
 */
class BlockModuleTest extends ModuleWebTestCase
{
    protected $listUrl = '/admin/block/list';
    protected $formUrl = '/admin/block/edit';
}
