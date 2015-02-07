<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NewsBundle\Module;

use Clastic\CoreBundle\Module\SubmoduleInterface;
use Clastic\NodeBundle\Module\NodeModuleInterface;

/**
 * NewsTagModule
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NewsTagModule implements NodeModuleInterface, SubmoduleInterface
{
    /**
     * The name of the module.
     *
     * @return string
     */
    public function getName()
    {
        return 'Tag';
    }

    /**
     * The the unique identifier of the module.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return 'news/tag';
    }

    /**
     * The identifier of the parent module.
     *
     * @return string
     */
    public function getParentIdentifier()
    {
        return 'news';
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return 'ClasticNewsBundle:Tag';
    }

    /**
     * @return string|bool
     */
    public function getDetailTemplate()
    {
        return 'ClasticNewsBundle:Front:detail.html.twig';
    }
}
