<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Services\RouteGeneratorException;
use Stringy;
use Gate;

class RouteGeneratorService
{
    const ROUTE_INDEX  = 'index';
    const ROUTE_SHOW   = 'show';
    const ROUTE_NEW    = 'new';
    const ROUTE_CREATE = 'create';
    const ROUTE_EDIT   = 'edit';
    const ROUTE_UPDATE = 'update';
    const ROUTE_DELETE = 'delete';

    const HTTP_METHOD_GET    = 'get';
    const HTTP_METHOD_POST   = 'post';
    const HTTP_METHOD_PUT    = 'put';
    const HTTP_METHOD_DELETE = 'delete';

    const MIDDLEWARE_POLICY_PREFIX = 'can:';

    const ROUTES = [
        self::ROUTE_INDEX,
        self::ROUTE_SHOW,
        self::ROUTE_NEW,
        self::ROUTE_CREATE,
        self::ROUTE_EDIT,
        self::ROUTE_UPDATE,
        self::ROUTE_DELETE,
    ];

    const RESOURCES = [
        self::ROUTE_INDEX  => self::HTTP_METHOD_GET,
        self::ROUTE_SHOW   => self::HTTP_METHOD_GET,
        self::ROUTE_NEW    => self::HTTP_METHOD_GET,
        self::ROUTE_CREATE => self::HTTP_METHOD_POST,
        self::ROUTE_EDIT   => self::HTTP_METHOD_GET,
        self::ROUTE_UPDATE => self::HTTP_METHOD_PUT,
        self::ROUTE_DELETE => self::HTTP_METHOD_DELETE,
    ];

    public function resource(string $prefix, string $controller, array $routes = self::ROUTES) : void
    {
        // camelize prefix
        $prefixParsed = Stringy::camelize($prefix);

        foreach ($routes as $route) {
            if (in_array($route, self::ROUTES)) {
                // get url and policy
                $url              = $this->getUrl($prefixParsed, $route);
                $middlewarePolicy = $this->getPolicy($prefixParsed, $route);

                // create route
                app('router')->{self::RESOURCES[$route]}($url, $controller . '@' . $route)
                    ->name($prefixParsed . '.' . $route)
                    ->middleware($middlewarePolicy);
            } else {
                throw new RouteGeneratorException('Route not valid');
            }
        }
    }

    protected function getUrl(string $prefix, string $route) : string
    {
        $url = $prefix;

        // add bind model
        if (in_array($route, [self::ROUTE_EDIT, self::ROUTE_UPDATE, self::ROUTE_DELETE])) {
            $url .= '/{' . $prefix . '}';
        }

        // add suffix to url when is form
        if (in_array($route, [self::ROUTE_NEW, self::ROUTE_EDIT])) {
            $url .= '/' . $route;
        }

        return $url;
    }

    protected function getPolicy(string $prefix, string $route) : ?string
    {
        $middleware = null;
        $policy     = $prefix . '.' . $route;

        if (in_array($route, [self::ROUTE_EDIT, self::ROUTE_UPDATE, self::ROUTE_DELETE])) {
            $middleware = self::MIDDLEWARE_POLICY_PREFIX . $policy . ',' . $prefix;
        } else {
            $middleware = self::MIDDLEWARE_POLICY_PREFIX . $policy;
        }

        if (Gate::has($policy)) {
            return $middleware;
        }

        return null;
    }
}
