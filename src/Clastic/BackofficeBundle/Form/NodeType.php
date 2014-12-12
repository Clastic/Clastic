<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * NodeType
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('tabs', 'tabs', array('inherit_data' => true))
                    ->add(
                        $this->createTab($builder, 'General')
                            ->add('title', 'text', array(
                                    'property_path' => 'node.title'
                                ))
                            ->add('body', 'textarea')
                    )
                    ->add(
                        $this->createActionTab($builder)
                            ->add('save', 'submit', array(
                                    'label' => 'Save',
                                    'attr' => array('class' => 'btn btn-success'),
                                ))
                    )
            );

    }

    private function createTab(FormBuilderInterface $builder, $name, $options = array())
    {
        $options = array_replace(
            $options,
            array(
                'inherit_data' => true,
            ))
        ;

        return $builder->create($name, 'tabs_tab', $options);
    }

    private function createActionTab(FormBuilderInterface $builder)
    {
        return $builder->create('actions', 'tabs_tab_actions', array(
            'mapped' => false,
            'inherit_data' => true,
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'clastic_node';
    }
}
