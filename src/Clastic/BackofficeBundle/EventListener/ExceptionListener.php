<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\EventListener\ExceptionListener as BaseExceptionListener;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ExceptionListener extends BaseExceptionListener
{
    /**
     * @param SecurityContext $securityContext
     * @param LoggerInterface $logger
     */
    public function __construct(SecurityContext $securityContext, LoggerInterface $logger = null)
    {
        parent::__construct('clastic.backoffice.controller.exception:showAction', $logger);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => array('onKernelException', -127),
        );
    }
}
