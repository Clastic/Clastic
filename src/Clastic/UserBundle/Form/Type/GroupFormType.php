<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
                $builder->create('tabs', 'tabs', ['inherit_data' => true])
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
            ->add('name', 'text', ['label' => 'user_group.form.tab.general.field.name'])
            ->add('roles', 'multi_select', [
                'choices' => $this->getAvailableRoles($builder),
                'label' => 'user.form.tab.role.field.roles',
            ]);
    }

    private function createActionTab(FormBuilderInterface $builder)
    {
        return $builder->create('actions', 'tabs_tab_actions', [
                'mapped' => false,
                'inherit_data' => true,
            ])
            ->add('save', 'submit', [
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

        return $builder->create($name, 'tabs_tab', $options);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'clastic',
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'clastic_user_group';
    }
}
