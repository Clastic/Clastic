<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\UserBundle\Form\Type;

use Clastic\BackofficeBundle\Form\Type\MultiSelectType;
use Clastic\BackofficeBundle\Form\Type\TabsTabActionsType;
use Clastic\BackofficeBundle\Form\Type\TabsTabType;
use Clastic\BackofficeBundle\Form\Type\TabsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * UserType.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class GroupFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('tabs', TabsType::class, ['inherit_data' => true])
                    ->add($this->createGeneralTab($builder))
                    ->add($this->createActionTab($builder))
            );
    }

    private function getAvailableRoles(FormBuilderInterface $builder)
    {
        $roles = [
            'ROLE_ADMIN' => 'Admin',
            'ROLE_USER' => 'User',
        ];

        return $roles;
    }

    private function createGeneralTab(FormBuilderInterface $builder)
    {
        return $this->createTab(
                $builder,
                'general',
                ['label' => 'user.form.tab.general.label']
            )
            ->add('name', TextType::class, ['label' => 'user_group.form.tab.general.field.name'])
            ->add('roles', MultiSelectType::class, [
                'choices' => array_flip($this->getAvailableRoles($builder)),
                'label' => 'user.form.tab.role.field.roles',
            ]);
    }

    private function createActionTab(FormBuilderInterface $builder)
    {
        return $builder->create('actions', TabsTabActionsType::class, [
                'mapped' => false,
                'inherit_data' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'node.form.tab.action.field.save',
                'attr' => ['class' => 'btn btn-success'],
            ]);
    }

    private function createTab(FormBuilderInterface $builder, $name, $options = array())
    {
        $options = array_replace(
            $options,
            ['inherit_data' => true]
        );

        return $builder->create($name, TabsTabType::class, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'translation_domain' => 'clastic',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'clastic_user_group';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
