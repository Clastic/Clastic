<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BlockBundle\Form\Type;

use Clastic\BackofficeBundle\Form\Type\TabsTabActionsType;
use Clastic\BackofficeBundle\Form\Type\TabsTabType;
use Clastic\BackofficeBundle\Form\Type\TabsType;
use Clastic\BackofficeBundle\Form\Type\WysiwygType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * MenuType.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class BlockFormType extends AbstractType
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
                    ->add($this->createGeneralTab($builder))
                    ->add($this->createContentTab($builder))
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

    private function createGeneralTab(FormBuilderInterface $builder)
    {
        return $this
            ->createTab($builder, 'general', array('label' => 'General'))
            ->add('title', TextType::class, array(
                'label' => 'Title',
            ))
            ->add('identifier', TextType::class, array(
                'label' => 'Identifier',
            ));
    }

    private function createContentTab(FormBuilderInterface $builder)
    {
        return $this
            ->createTab($builder, 'content', array('label' => 'Content'))
            ->add('body', WysiwygType::class);
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
                'label' => 'node.form.tab.action.field.save',
                'attr' => array('class' => 'btn btn-success'),
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'translation_domain' => 'clastic',
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
