<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NewsBundle\Form\Module;

use Clastic\BackofficeBundle\Form\Type\TreeType;
use Clastic\NodeBundle\Form\Extension\AbstractNodeTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Router;

/**
 * NewsCategoryFormExtension
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NewsCategoryFormExtension extends AbstractNodeTypeExtension
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     */
    function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->findTab($builder, 'general')
          ->add('description', 'wysiwyg')
          ->add('position', new TreeType($this->router->generate('clastic_backoffice_news_category_tree')));
    }
}
