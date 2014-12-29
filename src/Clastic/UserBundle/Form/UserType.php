<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class UserType extends AbstractType
{
    private $isNew;

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
                    ->add($this->createActionTab($builder))
            );
    }

    private function createGeneralTab(FormBuilderInterface $builder)
    {
        return $this->createTab($builder, 'general', array('label' => 'General'))
            ->add('username', 'text', array(
                'label' => 'Username',
            ))
            ->add('email', 'text', array(
                'label' => 'Email',
            ))
            ->add('enabled', 'checkbox', array(
                'value' => true,
            ));
    }

    private function createPasswordTab(FormBuilderInterface $builder)
    {
        return $this->createTab($builder, 'password', array('label' => 'Password'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'required' => $this->isNew,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Confirm password'),
                'invalid_message' => 'The passwords don\'t match',
            ));
    }

    private function createRoleTab(FormBuilderInterface $builder)
    {
        return $this->createTab($builder, 'role', array('label' => 'Role'))
            ->add('roles', 'multi_select', array(
                'choices' => array(
                    'ROLE_ADMIN' => 'Admin',
                    'ROLE_USER' => 'User',
                ),
            ));
    }

    private function createActionTab(FormBuilderInterface $builder)
    {
        return $builder->create('actions', 'tabs_tab_actions', array(
                'mapped' => false,
                'inherit_data' => true,
            ))
            ->add('save', 'submit', array(
                'label' => 'Save',
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

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
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
