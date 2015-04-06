<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NodeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * NodeType
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
                $builder->create('tabs', 'tabs', array('inherit_data' => true))
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
                'translation_domain' => 'clastic',
            ))
            ->add('title', 'text', array(
                'property_path' => 'node.title',
                'label' => 'node.form.tab.general.field.title',
            ));
    }

    private function createPublicationTab(FormBuilderInterface $builder)
    {
        return $this
            ->createTab($builder, 'publication', array(
                'label' => 'node.form.tab.publication.label',
                'translation_domain' => 'clastic',
            ))
            ->add('available', 'checkbox', array(
                'property_path' => 'node.publication.available',
                'label' => 'node.form.tab.publication.field.available',
                'required' => false,
            ))->add('publishedFrom', 'datepicker', array(
                'property_path' => 'node.publication.publishedFrom',
                'label' => 'node.form.tab.publication.field.published_from',
                'required' => false,
            ))->add('publishedTill', 'datepicker', array(
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
                'translation_domain' => 'clastic',
            ))
            ->add('author', 'entity', array(
                'class' => 'ClasticUserBundle:User',
                'property_path' => 'node.user',
                'label' => 'node.form.tab.author_information.field.author',
                'required' => true,
            ))
            ->add('created', 'datepicker', array(
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

        return $builder->create($name, 'tabs_tab', $options);
    }

    private function createActionTab(FormBuilderInterface $builder)
    {
        return $builder
            ->create('actions', 'tabs_tab_actions', array(
                'mapped' => false,
                'inherit_data' => true,
                'translation_domain' => 'clastic',
            ))
            ->add('save', 'submit', array(
                'label' => 'node.form.tab.action.field.save',
                'attr' => array('class' => 'btn btn-success'),
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
