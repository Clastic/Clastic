<?php

namespace Clastic\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ClasticUserExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }

    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (true === isset($bundles['FOSUserBundle'])) {
            $this->configureFOSUserBundle($container);
        }
    }

    /**
     * @param ContainerBuilder $container The service container
     */
    protected function configureFOSUserBundle(ContainerBuilder $container)
    {
        foreach (array_keys($container->getExtensions()) as $name) {
            switch ($name) {
                case 'fos_user':
                    $container->prependExtensionConfig(
                        $name,
                        array(
                            'db_driver' => 'orm',
                            'firewall_name' => 'backoffice',
                            'user_class' => 'Clastic\UserBundle\Entity\User',
                        )
                    );
                    break;
            }
        }
    }
}
