<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\MenuBundle\Form\Type;

use Clastic\BackofficeBundle\Form\Type\TreeType;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class MenuItemFormType extends AbstractType
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
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
                    ->add($this->createActionTab($builder))
                    ->add($this->createPositionTab($builder))
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

        return $builder->create($name, 'tabs_tab', $options);
    }

    /**
     * @param FormBuilderInterface $builder
     *
     * @return FormBuilderInterface
     */
    private function createGeneralTab(FormBuilderInterface $builder)
    {
        return $this->createTab($builder, 'general', array('label' => 'General'))
            ->add('title', 'text', array(
                'label' => 'Title',
            ))
            ->add('node', 'node', array(
                'required' => false,
                'placeholder' => 'None',
            ))
            ->add('url', 'text', array(
                'required' => false,
            ));
    }

    /**
     * @param FormBuilderInterface $builder
     *
     * @return FormBuilderInterface
     */
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

    /**
     * @param FormBuilderInterface $builder
     *
     * @return FormBuilderInterface
     */
    private function createPositionTab(FormBuilderInterface $builder)
    {
        $treeType = new TreeType(
            $this->router->generate(
                'clastic_backoffice_menu_item_tree',
                array('menuId' => $builder->getData()->getMenu()->getId()))
        );

        return $this->createTab($builder, 'position_tab', array(
            'label' => 'Position',
            ))
            ->add('position', $treeType);
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
        return 'clastic_menu';
    }
}
