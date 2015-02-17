<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BlogBundle\Module;

use Clastic\CoreBundle\Module\SubmoduleInterface;
use Clastic\NodeBundle\Module\NodeModuleInterface;

/**
 * NewsCategoryModule
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class BlogCategoryModule implements NodeModuleInterface, SubmoduleInterface
{
    /**
     * The name of the module.
     *
     * @return string
     */
    public function getName()
    {
        return 'Category';
    }

    /**
     * The the unique identifier of the module.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return 'blog/category';
    }

    /**
     * The identifier of the parent module.
     *
     * @return string
     */
    public function getParentIdentifier()
    {
        return 'blog';
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return 'ClasticBlogBundle:Category';
    }

    /**
     * @return string|bool
     */
    public function getDetailTemplate()
    {
        return 'ClasticBlogBundle:Front:detail.html.twig';
    }
}
