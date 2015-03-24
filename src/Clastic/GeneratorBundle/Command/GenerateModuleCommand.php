<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\GeneratorBundle\Command;

use Clastic\GeneratorBundle\ClasticGeneratorBundle;
use Clastic\GeneratorBundle\Generator\ModuleGenerator;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Initializes a Clastic module inside a bundle.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class GenerateModuleCommand extends GeneratorCommand
{
    protected function configure()
    {
        $this
            ->setName('clastic:generate:module')
            ->setAliases(array('generate:clastic:module'))
            ->setDescription('Generates a new Clastic module inside a bundle')
            ->addOption('module', null, InputOption::VALUE_REQUIRED, 'The module name to generate (shortcut notation)')
            ->addOption('entity', null, InputOption::VALUE_REQUIRED, 'The entity to manage')
            ->setHelp(<<<EOT
The <info>clastic:generate:module</info> task generates a new Clastic
module inside a bundle:
EOT
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();

        if ($input->isInteractive()) {
            $question = new ConfirmationQuestion($questionHelper->getQuestion('Do you confirm generation', 'yes', '?'), true);
            if (!$questionHelper->ask($input, $output, $question)) {
                $output->writeln('<error>Command aborted</error>');

                return 1;
            }
        }

        $module = Validators::validateModuleName($input->getOption('module'));
        $entity = Validators::validateEntityName($input->getOption('entity'));
        list($bundle, $module) = $this->parseShortcutNotation($module);
        $module = substr($module, 0, -6);

        $questionHelper->writeSection($output, 'Module generation');

        $bundle = $this->getContainer()->get('kernel')->getBundle($bundle);

        /** @var ModuleGenerator $generator */
        $generator = $this->getGenerator(new ClasticGeneratorBundle());
        $generator->generate($bundle, $module, $entity);

        $output->writeln('Generating the module code: <info>OK</info>');

        $questionHelper->writeGeneratorSummary($output, array());

        return 0;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();
        $questionHelper->writeSection($output, 'Welcome to the Clastic module generator');

        // namespace
        $output->writeln(array(
            '',
            'This command helps you generate Clastic modules.',
            '',
            'First, you need to give the module name you want to generate.',
            'You must use the shortcut notation like <comment>AcmeBlogBundle:BlogModule</comment>.',
            '',
        ));

        $bundleNames = array_keys($this->getContainer()->get('kernel')->getBundles());

        while (true) {
            $question = new Question($questionHelper->getQuestion('The Module name', $input->getOption('module')), $input->getOption('module'));
            $question->setValidator(array('Clastic\GeneratorBundle\Command\Validators', 'validateModuleName'));
            $question->setAutocompleterValues($bundleNames);
            $module = $questionHelper->ask($input, $output, $question);

            list($bundle, $module) = $this->parseShortcutNotation($module);

            try {
                /** @var BundleInterface $bundleInstance */
                $bundleInstance = $this->getContainer()->get('kernel')->getBundle($bundle);

                if (!file_exists($bundleInstance->getPath().'/Module/'.str_replace('\\', '/', $module).'.php')) {
                    break;
                }

                $output->writeln(sprintf('<bg=red>Module "%s:%s" already exists</>.', $bundle, $module));
            } catch (\Exception $e) {
                $output->writeln(sprintf('<bg=red>Bundle "%s" does not exist.</>', $bundle));
            }
        }
        $input->setOption('module', $bundle.':'.$module);

        while (true) {
            $question = new Question($questionHelper->getQuestion('The entity name', $input->getOption('entity')), $input->getOption('entity'));
            $question->setValidator(array('Clastic\GeneratorBundle\Command\Validators', 'validateEntityName'));
            $question->setAutocompleterValues($bundleNames);
            $entity = $questionHelper->ask($input, $output, $question);

            try {
                $this->getContainer()->get('doctrine')->getRepository($entity);

                break;
            } catch (\Exception $e) {
                $output->writeln(sprintf('<bg=red>Entity "%s" does not exist.</>', $entity));
            }
        }
        $input->setOption('entity', $entity);

        // summary
        $output->writeln(array(
            '',
            $this->getHelper('formatter')->formatBlock('Summary before generation', 'bg=blue;fg=white', true),
            '',
            sprintf("You are going to generate a \"<info>%s:%s</info>\" Clastic module", $bundle, $module),
            '',
        ));
    }

    protected function parseShortcutNotation($shortcut)
    {
        $entity = str_replace('/', '\\', $shortcut);

        if (false === $pos = strpos($entity, ':')) {
            throw new \InvalidArgumentException(sprintf('The module name must contain a : ("%s" given, expecting something like AcmeBlogBundle:BlogBundle)', $entity));
        }

        return array(substr($entity, 0, $pos), substr($entity, $pos + 1));
    }

    protected function createGenerator()
    {
        return new ModuleGenerator($this->getContainer()->get('filesystem'));
    }
}
