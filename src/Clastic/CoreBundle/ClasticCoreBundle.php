<?php

namespace Clastic\CoreBundle;

use Clastic\CoreBundle\DependencyInjection\Compiler\RegisterModulePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ClasticCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterModulePass());
    }
}
