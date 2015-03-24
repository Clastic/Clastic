<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NodeBundle\Filter;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodePublicationConfigurator
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var SecurityContext
     */
    protected $securityContext;

    /**
     * @param EntityManager   $entityManager
     * @param SecurityContext $securityContext
     */
    public function __construct(EntityManager $entityManager, SecurityContext $securityContext)
    {
        $this->entityManager   = $entityManager;
        $this->securityContext = $securityContext;
    }

    /**
     * Enable the NodePublicationFilter when not in the backoffice..
     */
    public function onKernelRequest()
    {
        $token = $this->securityContext->getToken();
        if (!$token) {
            return;
        }

        if (!$token instanceof UsernamePasswordToken) {
            return;
        }

        if ($token->getProviderKey() != 'backoffice') {
            return;
        }

        /** @var NodePublicationFilter $filter */
        $filter = $this->entityManager->getFilters()->enable('node_publication_filter');
        $filter->setApplyPublication(false);
    }
}
