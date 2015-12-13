<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\NodeBundle\Form\Type;

use Clastic\BackofficeBundle\Form\Type\DatePickerType;
use Clastic\BackofficeBundle\Form\Type\TabsTabActionsType;
use Clastic\BackofficeBundle\Form\Type\TabsTabType;
use Clastic\BackofficeBundle\Form\Type\TabsType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * NodeType.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeFormType extends AbstractType
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
                    ->add($this->createPublicationTab($builder))
                    ->add($this->createAuthorInformationTab($builder))
                    ->add($this->createActionTab($builder))
            );
    }

    private function createGeneralTab(FormBuilderInterface $builder)
    {
        return $this
            ->createTab($builder, 'general', array(
                'label' => 'node.form.tab.general.label',
                'position' => 'first',
            ))
            ->add('title', TextType::class, array(
                'property_path' => 'node.title',
                'label' => 'node.form.tab.general.field.title',
            ));
    }

    private function createPublicationTab(FormBuilderInterface $builder)
    {
        return $this
            ->createTab($builder, 'publication', array(
                'label' => 'node.form.tab.publication.label',
            ))
            ->add('available', CheckboxType::class, array(
                'property_path' => 'node.publication.available',
                'label' => 'node.form.tab.publication.field.available',
                'required' => false,
            ))->add('publishedFrom', DatePickerType::class, array(
                'property_path' => 'node.publication.publishedFrom',
                'label' => 'node.form.tab.publication.field.published_from',
                'required' => false,
            ))->add('publishedTill', DatePickerType::class, array(
                'property_path' => 'node.publication.publishedTill',
                'label' => 'node.form.tab.publication.field.published_till',
                'required' => false,
            ));
    }

    private function createAuthorInformationTab(FormBuilderInterface $builder)
    {
        return $this
            ->createTab($builder, 'author_information', array(
                'label' => 'node.form.tab.author_information.label',
            ))
            ->add('author', EntityType::class, array(
                'class' => 'ClasticUserBundle:User',
                'property_path' => 'node.user',
                'label' => 'node.form.tab.author_information.field.author',
                'required' => true,
            ))
            ->add('created', DatePickerType::class, array(
                'property_path' => 'node.created',
                'label' => 'node.form.tab.author_information.field.created',
                'disabled' => true,
            ));
    }

    private function createTab(FormBuilderInterface $builder, $name, $options = array())
    {
        $options = array_replace(
            $options,
            array(
                'inherit_data' => true,
            ));

        return $builder->create($name, TabsTabType::class, $options);
    }

    private function createActionTab(FormBuilderInterface $builder)
    {
        return $builder
            ->create('actions', TabsTabActionsType::class, array(
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
        return 'clastic_node';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
