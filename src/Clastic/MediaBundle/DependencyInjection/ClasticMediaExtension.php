<?php

namespace Clastic\MediaBundle\DependencyInjection;

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
class ClasticMediaExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @var string
     */
    private $formTemplate = 'ClasticMediaBundle:Form:fields.html.twig';

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

        if (true === isset($bundles['TwigBundle'])) {
            $this->configureTwigBundle($container);
        }
        if (true === isset($bundles['FMElfinderBundle'])) {
            $this->configureFMElfinderBundle($container);
        }
    }

    /**
     * @param ContainerBuilder $container The service container
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
     */
    protected function configureFMElfinderBundle(ContainerBuilder $container)
    {
        foreach (array_keys($container->getExtensions()) as $name) {
            switch ($name) {
                case 'fm_elfinder':
                    $container->prependExtensionConfig(
                        $name,
                        $this->getElFinderConfiguration()
                    );
                    break;
            }
        }
    }

    /**
     * Default ElFinder configuration.
     *
     * @return array
     */
    protected function getElFinderConfiguration()
    {
        return array(
            'instances' => array(
                'default' => array(
                    'locale' => '',
                    'editor' => 'ckeditor',
                    'fullscreen' => true,
                    'theme' => 'smoothness',
                    'include_assets' => true,
                    'connector' => array(
                        'roots' => array(
                            'uploads' => array(
                                'show_hidden' => false,
                                'driver' => 'clastic.elfinder.driver.filesystem',
                                'path' => 'uploads',
                                'upload_allow' => array('all'),
                                'upload_deny' => array(),
                                'upload_max_size' => '20M',
                            ),
                        ),
                    ),
                ),
            ),
        );
    }
}
