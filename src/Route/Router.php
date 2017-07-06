<?php namespace Framework\Core\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    /**
     * @var RouteCollection
     */
    protected $routes;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Router constructor.
     * @param Request $request
     * @param array $routingConfig
     */
    public function __construct(Request $request, $routingConfig)
    {
        $this->request = $request;
        $this->routes = new RouteCollection();
        $this->prepareRouteCollection($routingConfig);

        $context = new RequestContext();

        $matcher = new UrlMatcher($this->routes, $context->fromRequest($this->request));
        $this->parameters = $matcher->matchRequest($this->request);

        $this->controller = $this->parameters['_controller'];
        $this->action = $this->parameters['_action'] ? $this->parameters['_action'] . 'Action' : 'indexAction';
    }

    protected function prepareRouteCollection($routingConfig)
    {
        foreach ($routingConfig as $path => $params) {
            $route = new Route($path, $params, [], [], '', [], $params['_methods'] ?: []);
            $this->routes->add($params['_route_name'], $route);
        }
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    public function getHttpMethod()
    {

    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}