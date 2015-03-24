<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NodeBundle\Form\Extension;

use Clastic\BackofficeBundle\Form\TabHelper;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * NodeTypeExtension
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
abstract class AbstractNodeTypeExtension
{
    /**
     * @var TabHelper
     */
    private $tabHelper;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
    }

    /**
     * @param FormBuilderInterface $builder
     * @param string               $name
     *
     * @deprecated Use TabHelper instead.
     *
     * @return FormBuilderInterface
     */
    protected function findTab(FormBuilderInterface $builder, $name)
    {
        return $builder->get('tabs')->get($name);
    }

    /**
     * Create a new tab.
     *
     * @param FormBuilderInterface $builder
     * @param string               $name
     * @param array                $options
     *
     * @deprecated Use TabHelper instead.
     *
     * @return FormBuilderInterface
     */
    final protected function createTab(FormBuilderInterface $builder, $name, $options = array())
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
     * @return TabHelper
     */
    protected function getTabHelper(FormBuilderInterface $builder)
    {
        if (is_null($this->tabHelper)) {
            $this->tabHelper = new TabHelper($builder);
        }

        return $this->tabHelper;
    }
}
