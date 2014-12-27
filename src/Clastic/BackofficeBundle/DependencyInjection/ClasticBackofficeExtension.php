<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ClasticBackofficeExtension extends Extension implements PrependExtensionInterface
{
    private $formTemplate = 'ClasticBackofficeBundle:Form:fields.html.twig';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

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

        if (true === isset($bundles['TwigBundle'])) {
            $this->configureTwigBundle($container);
        }

        if (true === isset($bundles['SecurityBundle'])) {
            $this->configureSecurityBundle($container);
        }
    }

    /**
     * @param ContainerBuilder $container The service container
     *
     * @return void
     */
    protected function configureTwigBundle(ContainerBuilder $container)
    {
        foreach (array_keys($container->getExtensions()) as $name) {
            switch ($name) {
                case 'twig':
                    $container->prependExtensionConfig(
                        $name,
                        array('form' => array('resources' => array($this->formTemplate)))
                    );
                    break;
            }
        }
    }

    /**
     * @param ContainerBuilder $container The service container
     *
     * @return void
     */
    protected function configureSecurityBundle(ContainerBuilder $container)
    {
        foreach (array_keys($container->getExtensions()) as $name) {
            switch ($name) {
                case 'security':
                    $container->prependExtensionConfig(
                        $name,
                        array(
                            'encoders' => array(
                                'FOS\UserBundle\Model\UserInterface' => 'sha512',
                            ),
                            'role_hierarchy' => array(
                                'ROLE_ADMIN' => 'ROLE_USER',
                                'ROLE_SUPER_ADMIN' => 'ROLE_ADMIN',
                            ),
                        )
                    );
                    break;
            }
        }
    }
}
