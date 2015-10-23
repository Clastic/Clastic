<?php

namespace Clastic\SecurityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ClasticSecurityBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
