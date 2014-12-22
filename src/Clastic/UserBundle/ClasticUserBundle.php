<?php

namespace Clastic\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ClasticUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
