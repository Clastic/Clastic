<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\Controller;

use Symfony\Bundle\TwigBundle\Controller\ExceptionController as BaseExceptionController;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ExceptionController extends BaseExceptionController
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Router
     */
    private $router;

    /**
     * @param \Twig_Environment     $twig
     * @param int                   $debug
     * @param TokenStorageInterface $tokenStorage
     * @param Router                $router
     */
    public function __construct(\Twig_Environment $twig, $debug, TokenStorageInterface $tokenStorage, Router $router)
    {
        $this->twig = $twig;
        $this->debug = $debug;
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    protected function findTemplate(Request $request, $format, $code, $showException)
    {
        $this->request = $request;

        return parent::findTemplate($request, $format, $code, $showException);
    }

    /**
     * @param TemplateReference $template
     *
     * @return bool
     */
    protected function templateExists($template)
    {
        if ($this->isBackoffice() || $this->inBackofficeRoot()) {
            $template = '@ClasticBackofficeBundle/Exception/exception_full.html.twig';
        }

        return parent::templateExists($template);
    }

    /**
     * @return bool
     */
    private function isBackoffice()
    {
        $token = $this->tokenStorage->getToken();
        if (!$token) {
            return false;
        }

        if (!$token instanceof UsernamePasswordToken) {
            return false;
        }

        if ($token->getProviderKey() != 'backoffice') {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    private function inBackofficeRoot()
    {
        return (bool) preg_match('|^'.$this->router->generate('clastic_backoffice_dashboard').'(.*)|', $this->request->getPathInfo());
    }
}
