<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NewsBundle\Form\Module;

use Clastic\NodeBundle\Form\Extension\AbstractNodeTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Joeri van Dooren
 */
class NewsFormExtension extends AbstractNodeTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->getTabHelper($builder)->findTab('general')
          ->add('body', 'wysiwyg');

        $this->getTabHelper($builder)
            ->createTab('category', 'Category', array(
                'position' => 'first',
            ))
            ->add('categories', 'entity_multi_select', array(
                'class' => 'ClasticNewsBundle:Category',
                'property' => 'node.title',
                'required' => false,
            ));

        $this->getTabHelper($builder)
            ->createTab('tag', 'Tag', array(
                'position' => 'first',
            ))
            ->add('tags', 'entity_multi_select', array(
                'class' => 'ClasticNewsBundle:Tag',
                'property' => 'node.title',
                'required' => false,
            ));
    }
}
