<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\TaxonomyBundle\Form\Module;

use Clastic\BackofficeBundle\Form\Type\TreeType;
use Clastic\NodeBundle\Form\Extension\AbstractNodeTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Router;

/**
 * TaxonomyFormExtension.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class TaxonomyFormExtension extends AbstractNodeTypeExtension
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $url = $this->router
            ->generate('clastic_backoffice_taxonomy_category_tree', array(
                'entityName' => get_class($builder->getData()),
            ));

        $this->getTabHelper($builder)->findTab('general')
          ->add('description', 'wysiwyg')
          ->add('position', new TreeType($url));
    }
}
