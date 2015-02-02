<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NewsBundle\Module;

use Clastic\NodeBundle\Module\NodeModuleInterface;

/**
 * @author Joeri van Dooren
 */
class NewsModule implements NodeModuleInterface
{
    /**
     * The name of the module.
     *
     * @return string
     */
    public function getName()
    {
        return 'News';
    }

    /**
     * The the unique identifier of the module.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return 'news';
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return 'ClasticNewsBundle:News';
    }

    /**
     * @return string|bool
     */
    public function getDetailTemplate()
    {
        return 'ClasticNewsBundle:Front:detail.html.twig';
    }
}
