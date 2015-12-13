<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\AliasBundle\Form\Extension;

use Clastic\AliasBundle\Form\Type\AliasType;
use Symfony\Component\Form\AbstractExtension;
use Symfony\Component\HttpFoundation\RequestStack;

class AliasExtension extends AbstractExtension
{
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    protected function loadTypes()
    {
        return array(
            new AliasType($this->request),
        );
    }
}
