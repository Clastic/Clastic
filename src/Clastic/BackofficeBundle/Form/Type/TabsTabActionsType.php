<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class TabsTabActionsType extends TabsTabType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'tab_show' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'tabs_tab';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tabs_tab_actions';
    }
}
