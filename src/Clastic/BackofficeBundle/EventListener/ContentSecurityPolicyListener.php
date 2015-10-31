<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ContentSecurityPolicyListener
{
    private $environment;

    public function __construct($environment)
    {
        $this->environment = $environment;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$event->isMasterRequest()) {
            return;
        }

        if ($request->getRequestFormat() != 'html') {
            return;
        }

        if (!preg_match('/^\/admin/', $request->getPathInfo())) {
            return;
        }

        $event->getResponse()->headers->set('Content-Security-Policy', $this->buildOptions());
    }

    private function buildOptions()
    {
        $options = [
            'default-src' => '',
            'img-src'     => 'https://secure.gravatar.com',
            'font-src'    => 'https://netdna.bootstrapcdn.com',

            // Needed for CKeditor
            'style-src'   => '\'unsafe-inline\'',
            'script-src'  => '\'unsafe-inline\' \'unsafe-eval\'',

            // Needed for jsTree
            'child-src'  => 'blob:',
        ];

        if ($this->environment == 'dev') {
            $options['img-src'] .= ' data:';
        }

        $options = array_map(function ($value, $key) {
            return trim(sprintf('%s \'self\' %s', $key, $value));
        }, $options, array_keys($options));

        return implode('; ', $options);
    }
}
