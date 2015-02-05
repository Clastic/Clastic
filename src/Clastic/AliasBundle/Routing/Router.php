<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\AliasBundle\Routing;

use Clastic\AliasBundle\Entity\AliasRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class Router extends \Symfony\Bundle\FrameworkBundle\Routing\Router
{
    private $container;

    /**
     * @param ContainerInterface  $container
     * @param mixed               $resource
     * @param array               $options
     * @param RequestContext|null $context
     */
    public function __construct(ContainerInterface $container, $resource, array $options = array(), RequestContext $context = null)
    {
        parent::__construct($container, $resource, $options, $context);

        $this->container = $container;
    }

    /**
     * Tries to match a request with a set of routes.
     *
     * If the matcher can not find information, it must throw one of the exceptions documented
     * below.
     *
     * @param Request $request The request to match
     *
     * @return array An array of parameters
     *
     * @throws ResourceNotFoundException If no matching resource could be found
     * @throws MethodNotAllowedException If a matching resource was found but the request method is not allowed
     */
    public function matchRequest(Request $request)
    {
        try {
            $parameters = parent::matchRequest($request);
            $canonical = $request->getPathInfo();

        } catch (ResourceNotFoundException $e) {

            $alias = $this->getAliasRepo()->findOneBy(array(
                'alias' => substr($request->getPathInfo(), 1),
            ));

            if (!$alias) {
                throw $e;
            }

            $parameters = $this->getMatcher()
              ->match('/' . $alias->getPath());
            $canonical = $alias->getPath();
        }

        return array_merge($parameters, array(
            '_canonical' => $canonical,
        ));
    }

    /**
     * @return AliasRepository
     */
    private function getAliasRepo()
    {
        return $this->container->get('clastic.repo.alias');
    }

    /**
     * Generates a URL or path for a specific route based on the given parameters.
     *
     * Parameters that reference placeholders in the route pattern will substitute them in the
     * path or host. Extra params are added as query string to the URL.
     *
     * When the passed reference type cannot be generated for the route because it requires a different
     * host or scheme than the current one, the method will return a more comprehensive reference
     * that includes the required params. For example, when you call this method with $referenceType = ABSOLUTE_PATH
     * but the route requires the https scheme whereas the current scheme is http, it will instead return an
     * ABSOLUTE_URL with the https scheme and the current host. This makes sure the generated URL matches
     * the route in any case.
     *
     * If there is no route with the given name, the generator must throw the RouteNotFoundException.
     *
     * @param string      $name          The name of the route
     * @param mixed       $parameters    An array of parameters
     * @param bool|string $referenceType The type of reference to be generated (one of the constants)
     *
     * @return string The generated URL
     *
     * @throws RouteNotFoundException              If the named route doesn't exist
     * @throws MissingMandatoryParametersException When some parameters are missing that are mandatory for the route
     * @throws InvalidParameterException           When a parameter value for a placeholder is not correct because
     *                                             it does not match the requirement
     *
     * @api
     */
    public function generate($name, $parameters = array(), $referenceType = \Symfony\Component\Routing\Router::ABSOLUTE_PATH)
    {
        $path = parent::generate($name, $parameters, $referenceType);

        if (preg_match('/^(\/[a-zA-Z]+\/[0-9]+)(\?.*)*/', $path, $matches)) {
            $alias = $this->getAliasRepo()->findOneBy(array(
                'path' => $matches[1],
              ));

            if ($alias) {
                return $alias->getAlias() . (isset($matches[2]) ? $matches[2] : '');
            }
        }

        return $path;
    }
}
