<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NodeBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodePublicationConfigurator
{
    protected $em;

    /**
     * @var SecurityContext
     */
    protected $securityContext;

    public function __construct($em, SecurityContext $securityContext)
    {
        $this->em              = $em;
        $this->securityContext = $securityContext;
    }

    public function onKernelRequest()
    {
        $token = $this->securityContext->getToken();
        if (!$token) {
            return;
        }

        if (!$token instanceof UsernamePasswordToken) {
            return;
        }

        if ($this->securityContext->getToken()->getProviderKey() != 'backoffice') {
            return;
        }

        /** @var NodePublicationFilter $filter */
        $filter = $this->em->getFilters()->enable('node_publication_filter');
        $filter->setApplyPublication(false);
    }
}
