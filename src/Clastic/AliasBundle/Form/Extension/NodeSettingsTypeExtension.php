<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\AliasBundle\Form\Extension;

use Clastic\AliasBundle\Entity\AliasPattern;
use Clastic\AliasBundle\Entity\AliasPatternRepository;
use Clastic\CoreBundle\Module\ModuleManager;
use Clastic\NodeBundle\Module\NodeModuleInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * NodeTypeExtension
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeSettingsTypeExtension extends AbstractTypeExtension
{
    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @var ModuleManager
     */
    private $moduleManager;

    /**
     * @param RegistryInterface $registry
     * @param ModuleManager     $moduleManager
     */
    public function __construct(RegistryInterface $registry, ModuleManager $moduleManager)
    {
        $this->registry = $registry;
        $this->moduleManager = $moduleManager;
    }

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return 'clastic_node_settings';
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $builder->getData();

        $module = $this->moduleManager->getModule($data['module']);

        if (!$module instanceof NodeModuleInterface) {
            return;
        }

        $builder->addEventListener(FormEvents::POST_SUBMIT, array($this, 'save'));
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'load'));

        $builder->get('tabs')
            ->add(
                $this->createTab($builder, 'alias', array('label' => 'Alias'))
                    ->add('alias_pattern', 'alias', array(
                        'required' => false,
                        'autofill' => false,
                    ))
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
     * @param FormEvent $event
     */
    public function load(FormEvent $event)
    {
        $data = $event->getData();

        $pattern = $this->getRepo()->findOneBy(array(
            'moduleIdentifier' => $data['module'],
        ));

        $data['alias_pattern'] = '{title}';
        if ($pattern) {
            $data['alias_pattern'] = $pattern->getPattern();
        }
        $event->setData($data);
    }

    /**
     * @param FormEvent $event
     */
    public function save(FormEvent $event)
    {
        $data = $event->getData();

        $pattern = $this->getRepo()->findOneBy(array(
            'moduleIdentifier' => $data['module'],
        ));

        if (!$pattern) {
            $pattern = new AliasPattern();
            $pattern->setModuleIdentifier($data['module']);
        }

        $pattern->setPattern($data['alias_pattern']);

        $this->registry->getManager()->persist($pattern);
    }

    /**
     * @return AliasPatternRepository
     */
    public function getRepo()
    {
        return $this->registry->getRepository('ClasticAliasBundle:AliasPattern');
    }
}
