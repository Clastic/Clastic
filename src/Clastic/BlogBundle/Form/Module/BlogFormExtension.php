<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BlogBundle\Form\Module;

use Clastic\NodeBundle\Form\Extension\AbstractNodeTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * NodeTypeExtension
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class BlogFormExtension extends AbstractNodeTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->findTab($builder, 'general')
            ->add('introduction', 'wysiwyg')
            ->add('body', 'wysiwyg');

        $builder->get('tabs')
            ->add(
                $this->createTab($builder, 'category', array('label' => 'Category'))
                    ->add('categories', 'entity_multi_select', array(
                        'class' => 'ClasticBlogBundle:Category',
                        'property' => 'node.title',
                        'required' => false,
                    ))
            );

        $builder->get('tabs')->add($this
            ->createTab($builder, 'links', array(
                'label' => 'Links',
                'position' => 'first',
            ))
            ->add('links', 'collection', array(
                'type' => 'link',
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'mapped' => false,
            ))
        );
    }
}
