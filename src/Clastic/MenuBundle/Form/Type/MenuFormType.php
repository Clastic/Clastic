<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\MenuBundle\Form\Type;

use Clastic\BackofficeBundle\Form\Type\TabsTabActionsType;
use Clastic\BackofficeBundle\Form\Type\TabsTabType;
use Clastic\BackofficeBundle\Form\Type\TabsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * MenuType.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class MenuFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('tabs', TabsType::class, array('inherit_data' => true))
                    ->add(
                        $this->createTab($builder, 'general', array('label' => 'General'))
                            ->add('title', TextType::class, array(
                                    'label' => 'Title',
                                ))
                            ->add('identifier', TextType::class, array(
                                'label' => 'Identifier',
                            ))
                    )
                    ->add($this->createActionTab($builder))
            );
    }

    /**
     * @param FormBuilderInterface $builder
     * @param string               $name
     * @param array                $options
     *
     * @return FormBuilderInterface
     */
    private function createTab(FormBuilderInterface $builder, $name, $options = array())
    {
        $options = array_replace(
            $options,
            array(
                'inherit_data' => true,
            ));

        return $builder->create($name, TabsTabType::class, $options);
    }

    /**
     * @param FormBuilderInterface $builder
     *
     * @return FormBuilderInterface
     */
    private function createActionTab(FormBuilderInterface $builder)
    {
        return $builder->create('actions', TabsTabActionsType::class, array(
            'mapped' => false,
            'inherit_data' => true,
        ))
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array('class' => 'btn btn-success'),
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'clastic_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
