<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\TextBundle\Form\Module;

use Clastic\NodeBundle\Form\Extension\AbstractNodeTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * NodeTypeExtension
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class TextFormExtension extends AbstractNodeTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->getTabHelper($builder)->findTab('general')
            ->add('body', 'wysiwyg');
    }
}
