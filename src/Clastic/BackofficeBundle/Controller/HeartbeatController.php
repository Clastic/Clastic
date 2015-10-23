<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * HeartBeatController.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class HeartbeatController extends Controller
{
    /**
     * @return Response
     */
    public function tickAction()
    {
        $maxlifetime = ini_get('session.gc_maxlifetime');

        return new JsonResponse([
            'lifetime' => $maxlifetime,
        ]);
    }
}
