<?php

namespace Clastic\NodeBundle;

use Clastic\NodeBundle\DependencyInjection\Compiler\RegisterModuleFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ClasticNodeBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterModuleFormPass());
    }
}
