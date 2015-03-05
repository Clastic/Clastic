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
use Symfony\Component\Form\FormBuilderInterface;

/**
 * MultiSelectType
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class LinkType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', 'text', array('required' => false))
            ->add('link', 'text', array('required' => false));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'link';
    }
}
