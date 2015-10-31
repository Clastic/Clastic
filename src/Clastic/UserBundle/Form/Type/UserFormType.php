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
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * UserType.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class UserFormType extends AbstractType
{
    private $isNew;

    /**
     * @param bool $isNew
     */
    public function __construct($isNew)
    {
        $this->isNew = $isNew;
    }

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
                    ->add($this->createPasswordTab($builder))
                    ->add($this->createRoleTab($builder))
                    ->add($this->createGroupTab($builder))
                    ->add($this->createActionTab($builder))
            );
    }

    private function getAvailableRoles(FormBuilderInterface $builder)
    {
        $roles = array(
            'ROLE_ADMIN' => 'Admin',
            'ROLE_USER' => 'User',
        );

        if ($builder->getData() && $builder->getData()->getId() === 1) {
            $roles['ROLE_SUPER_ADMIN'] = sprintf('%s (super)', $roles['ROLE_ADMIN']);
            unset($roles['ROLE_ADMIN']);
        }

        return $roles;
    }

    private function createGeneralTab(FormBuilderInterface $builder)
    {
        return $this->createTab(
                $builder,
                'general',
                array('label' => 'user.form.tab.general.label')
            )
            ->add('username', 'text', array(
                'label' => 'user.form.tab.general.field.username',
            ))
            ->add('email', 'text', array(
                'label' => 'user.form.tab.general.field.email',
            ))
            ->add('enabled', 'checkbox', array(
                'value' => true,
                'label' => 'user.form.tab.general.field.enabled',
                'required' => false,
            ));
    }

    private function createPasswordTab(FormBuilderInterface $builder)
    {
        return $this->createTab($builder, 'password', array('label' => 'user.form.tab.password.label'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'required' => $this->isNew,
                'first_options' => array('label' => 'user.form.tab.password.field.password'),
                'second_options' => array('label' => 'user.form.tab.password.field.password_repeat'),
                'invalid_message' => 'The passwords don\'t match',
            ));
    }

    private function createRoleTab(FormBuilderInterface $builder)
    {
        return $this->createTab($builder, 'role', array('label' => 'user.form.tab.role.label'))
            ->add('roles', 'multi_select', array(
                'choices' => $this->getAvailableRoles($builder),
                'label' => 'user.form.tab.role.field.roles',
            ));
    }

    private function createGroupTab(FormBuilderInterface $builder)
    {
        return $this->createTab($builder, 'group', array('label' => 'user.form.tab.group.label'))
            ->add('groups', 'entity_multi_select', array(
                'class' => 'ClasticUserBundle:Group',
                'label' => 'user.form.tab.group.field.groups',
            ));
    }

    private function createActionTab(FormBuilderInterface $builder)
    {
        return $builder->create('actions', 'tabs_tab_actions', array(
                'mapped' => false,
                'inherit_data' => true,
            ))
            ->add('save', 'submit', array(
                'label' => 'node.form.tab.action.field.save',
                'attr' => array('class' => 'btn btn-success'),
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

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'translation_domain' => 'clastic',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'clastic_user';
    }
}
