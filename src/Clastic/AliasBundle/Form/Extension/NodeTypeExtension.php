<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\AliasBundle\Form\Extension;

use Clastic\AliasBundle\EventListener\FormSubscriber;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * NodeTypeExtension
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeTypeExtension extends AbstractTypeExtension
{
    /**
     * @var FormSubscriber
     */
    private $formSubscriber;

    public function __construct(FormSubscriber $formSubscriber)
    {
        $this->formSubscriber = $formSubscriber;
    }
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return 'clastic_node';
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber($this->formSubscriber);
        $aliasTab = $this->createTab($builder, 'alias', array('label' => 'Alias'));

        $aliasTab->add('alias', 'text', array(
            'property_path' => 'node.alias.alias',
        ));

        $builder->get('tabs')
            ->add($aliasTab);
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

}
