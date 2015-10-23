<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\UserBundle\Tests\Functional;

use Clastic\BackofficeBundle\Tests\ModuleWebTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group functional
 */
class UserModuleTest extends ModuleWebTestCase
{
    protected $listUrl = '/admin/user/list';
    protected $formUrl = '/admin/user/edit';
}
