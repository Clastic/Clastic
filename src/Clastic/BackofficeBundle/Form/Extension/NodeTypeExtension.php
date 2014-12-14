<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Form\Extension;

use Clastic\BackofficeBundle\Event\NodeFormBuildEvent;
use Clastic\BackofficeBundle\NodeFormEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
     * @var AbstractNodeTypeExtension[]
     */
    private $nodeExtensions;

    /**
     *
     */
    public function __construct()
    {
        $this->nodeExtensions = array();
    }

    /**
     * @param string $type
     * @param AbstractNodeTypeExtension $extension
     */
    public function registerNodeFormExtension($type, AbstractNodeTypeExtension $extension)
    {
        $this->nodeExtensions[$type] = $extension;
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
        $type = $builder->getData()->getNode()->getType();

        if (isset($this->nodeExtensions[$type])) {
            $this->nodeExtensions[$type]->buildForm($builder, $options);
        }
    }

}
