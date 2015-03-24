<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * TabHelper
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class TabHelper
{
    /**
     * @var FormBuilderInterface
     */
    private $formBuilder;

    /**
     * @param FormBuilderInterface $formBuilder
     */
    public function __construct(FormBuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    /**
     * @param string $name
     *
     * @return FormBuilderInterface
     */
    public function findTab($name)
    {
        return $this->formBuilder->get('tabs')->get($name);
    }

    /**
     * Create a new tab and nest it under the tabs.
     *
     * @param string $name
     * @param string $label
     * @param array  $options
     *
     * @return FormBuilderInterface The created tab.
     */
    public function createTab($name, $label, $options = array())
    {
        $options = array_replace(
            $options,
            array(
                'label'        => $label,
                'inherit_data' => true,
            ));

        $tab = $this->formBuilder->create($name, 'tabs_tab', $options);
        $this->formBuilder->get('tabs')->add($tab);

        return $tab;
    }
}
