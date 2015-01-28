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
        $this->findTab($builder, 'general')
          ->add('body', 'wysiwyg');

        $builder->get('tabs')
            ->add(
                $this->createTab($builder, 'category', array('label' => 'Category'))
                    ->add('categories', 'entity_multi_select', array(
                        'class' => 'ClasticNewsBundle:Category',
                        'property' => 'node.title',
                        'required' => false,
                    ))
            );
    }

    private function createTab(FormBuilderInterface $builder, $name, $options = array())
    {
        $options = array_replace(
            $options,
            array(
                'inherit_data' => true,
            ));

        return $builder->create($name, 'tabs_tab', $options);
    }
}
