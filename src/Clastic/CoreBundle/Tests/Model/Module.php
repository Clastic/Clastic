<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CoreBundle\Tests\Model;

use Clastic\CoreBundle\Module\ModuleInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
abstract class Module implements ModuleInterface
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @param string $identifier
     */
    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }
    /**
     * The name of the module.
     *
     * @return string
     */
    public function getName()
    {
        return $this->identifier;
    }

    /**
     * The the unique identifier of the module.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
