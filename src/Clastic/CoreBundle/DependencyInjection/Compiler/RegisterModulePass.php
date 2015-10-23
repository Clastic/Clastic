<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers Clastic modules.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class RegisterModulePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('clastic.module_manager')) {
            return;
        }

        foreach ($container->findTaggedServiceIds('clastic.module') as $id => $attributes) {
            $container->getDefinition('clastic.module_manager')
              ->addMethodCall('registerModule', array(new Reference($id)));
        }
    }
}
