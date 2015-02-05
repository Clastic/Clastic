<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CoreBundle\Tests\Model;

use Clastic\CoreBundle\Module\SubmoduleInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class SubModule extends Module implements SubmoduleInterface
{
    /**
     * @var string
     */
    private $parent;

    /**
     * @param string $identifier
     * @param string $parent
     */
    public function __construct($identifier, $parent)
    {
        parent::__construct($identifier);

        $this->parent = $parent;
    }


    /**
     * The identifier of the parent module.
     *
     * @return string
     */
    public function getParentIdentifier()
    {
        return $this->parent;
    }

}
