<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\TextBundle\Module;

use Clastic\CoreBundle\Module\ModuleInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class TextModule implements ModuleInterface
{
    /**
     * The name of the module.
     *
     * @return string
     */
    public function getName()
    {
        return 'Text';
    }

    /**
     * The name of the module.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return 'text';
    }

}
 