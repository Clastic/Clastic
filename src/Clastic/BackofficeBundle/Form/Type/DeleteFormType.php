<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * DeleteForm.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class DeleteFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('tabs', TabsType::class, array('inherit_data' => true))
                    ->add(
                        $this->createActionTab($builder)
                            ->add('delete', SubmitType::class, array(
                                'label' => 'Delete',
                                'attr' => array('class' => 'btn btn-danger pull-left'),
                            ))
                            ->add('cancel', SubmitType::class, array(
                                'label' => 'Cancel',
                                'attr' => array('class' => 'btn btn-default pull-left'),
                            ))
                    )
            );
    }

    private function createActionTab(FormBuilderInterface $builder)
    {
        return $builder->create('actions', TabsTabActionsType::class, array(
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
