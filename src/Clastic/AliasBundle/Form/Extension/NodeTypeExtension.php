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
use Clastic\AliasBundle\Form\Type\AliasType;
use Clastic\BackofficeBundle\Form\Type\TabsTabType;
use Clastic\NodeBundle\Form\Type\NodeFormType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * NodeTypeExtension.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeTypeExtension extends AbstractTypeExtension
{
    /**
     * @var FormSubscriber
     */
    private $formSubscriber;

    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @param FormSubscriber    $formSubscriber
     * @param RegistryInterface $registry
     */
    public function __construct(FormSubscriber $formSubscriber, RegistryInterface $registry)
    {
        $this->formSubscriber = $formSubscriber;
        $this->registry = $registry;
    }

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return NodeFormType::class;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber($this->formSubscriber);
        $aliasTab = $this->createTab($builder, 'alias', array('label' => 'alias.module.alias'));

        $aliasTab->add('alias', AliasType::class, array(
            'property_path' => 'node.alias.alias',
            'alias_pattern' => $this->findPattern($builder),
            'label' => 'alias.module.alias',
        ));

        $builder->get('tabs')
            ->add($aliasTab);
    }

    protected function findPattern(FormBuilderInterface $builder)
    {
        $pattern = $this->registry->getRepository('ClasticAliasBundle:AliasPattern')->findOneBy(array(
            'moduleIdentifier' => $builder->getData()->getNode()->getType(),
        ));

        if ($pattern) {
            return $pattern->getPattern();
        }

        return '{title}';
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

        return $builder->create($name, TabsTabType::class, $options);
    }
}
