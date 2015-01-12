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
 * MultiSelectType
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class DeleteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('tabs', 'tabs', array('inherit_data' => true))
                    ->add(
                        $this->createActionTab($builder)
                            ->add('delete', 'submit', array(
                                'label' => 'Delete',
                                'attr' => array('class' => 'btn btn-danger pull-left'),
                            ))
                            ->add('cancel', 'submit', array(
                                'label' => 'Cancel',
                                'attr' => array('class' => 'btn btn-default pull-left'),
                            ))
                    )
            );
    }

    private function createActionTab(FormBuilderInterface $builder)
    {
        return $builder->create('actions', 'tabs_tab_actions', array(
            'mapped' => false,
            'inherit_data' => true,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'clastic_delete';
    }
}
