<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class DashboardEvent extends Event
{
    /**
     * @var array
     */
    private $mainTab;

    public function __construct($mainTab)
    {
        $this->mainTab = $mainTab;
    }

    /**
     * @return array
     */
    public function getMainTab()
    {
        return $this->mainTab;
    }

    /**
     * @param array $mainTab
     */
    public function setMainTab($mainTab)
    {
        $this->mainTab = $mainTab;
    }
}
