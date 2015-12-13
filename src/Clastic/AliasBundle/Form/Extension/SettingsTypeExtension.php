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
use Clastic\AliasBundle\Module\AliasModule;
use Clastic\BackofficeBundle\Form\Type\TabsTabType;
use Clastic\CoreBundle\Module\ModuleManager;
use Clastic\NodeBundle\Module\NodeModuleInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * NodeTypeExtension.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class SettingsTypeExtension extends AbstractTypeExtension
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
        return 'clastic_settings';
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $builder->getData();

        $module = $this->moduleManager->getModule($data['module']);

        if (!$module instanceof AliasModule) {
            return;
        }

        $builder->addEventListener(FormEvents::POST_SUBMIT, array($this, 'save'));
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'load'));

        $builder->get('tabs')
            ->add($this->createAliasTab($builder));
    }

    private function createAliasTab(FormBuilderInterface $builder)
    {
        $tab = $this->createTab($builder, 'alias', array('label' => 'Alias'));

        foreach ($this->moduleManager->getContentModules() as $module) {
            if (!$module instanceof NodeModuleInterface) {
                continue;
            }

            $mainModuleName = $module->getName();

            $fieldset = $builder
                ->create('fieldset_'.$module->getIdentifier(), 'fieldset', array(
                    'legend' => $mainModuleName,
                ))->add($this->getModuleId($module->getIdentifier()), 'alias', array(
                    'required' => false,
                    'autofill' => false,
                    'label' => false,
                ));

            foreach ($this->moduleManager->getSubmodules($module->getIdentifier()) as $submodule) {
                $fieldset->add($this->getModuleId($submodule->getIdentifier()), 'alias', array(
                    'required' => false,
                    'autofill' => false,
                    'label' => $submodule->getName(),
                ));
            }

            $tab->add($fieldset);
        }

        return $tab;
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

    /**
     * @param FormEvent $event
     */
    public function load(FormEvent $event)
    {
        $data = $event->getData();
        $patterns = $this->getRepo()->findAll();

        foreach ($this->moduleManager->getContentModules() as $module) {
            if (!$module instanceof NodeModuleInterface) {
                continue;
            }

            $data[$this->getModuleId($module->getIdentifier())] = '{title}';
            foreach ($this->moduleManager->getSubmodules($module->getIdentifier()) as $submodule) {
                $data[$this->getModuleId($submodule->getIdentifier())] = '{title}';
            }
        }

        /** @var AliasPattern $pattern */
        foreach ($patterns as $pattern) {
            $data[$this->getModuleId($pattern->getModuleIdentifier())] = $pattern->getPattern();
        }

        $event->setData($data);
    }

    /**
     * @param FormEvent $event
     */
    public function save(FormEvent $event)
    {
        $data = $event->getData();

        foreach ($data as $key => $value) {
            if (!preg_match('/^alias_pattern_(.*)/', $key, $matches)) {
                continue;
            }

            $identifier = $this->unClean($matches[1]);

            $pattern = $this->getRepo()->findOneBy(array(
                'moduleIdentifier' => $identifier,
            ));

            if (!$pattern) {
                $pattern = new AliasPattern();
                $pattern->setModuleIdentifier($identifier);
            }
            $pattern->setPattern($value);

            $this->registry->getManager()->persist($pattern);
        }
    }

    /**
     * @return AliasPatternRepository
     */
    public function getRepo()
    {
        return $this->registry->getRepository('ClasticAliasBundle:AliasPattern');
    }

    private function getModuleId($rawModuleId)
    {
        return $this->clean(sprintf('alias_pattern_%s', $rawModuleId));
    }

    private function clean($string)
    {
        return str_replace('/', ':', $string);
    }
    private function unClean($string)
    {
        return str_replace(':', '/', $string);
    }
}
