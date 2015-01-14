<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BlogBundle\Module;

use Clastic\NodeBundle\Module\NodeModuleInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class BlogModule implements NodeModuleInterface
{
    /**
     * The name of the module.
     *
     * @return string
     */
    public function getName()
    {
        return 'Blog';
    }

    /**
     * The name of the module.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return 'blog';
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return 'ClasticBlogBundle:Blog';
    }
}
