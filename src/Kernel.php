<?php namespace Framework\Core;

use Framework\Core\DependencyInjection\Container;
use Framework\Core\Route\Router;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\Debug\DebugClassLoader;

class Kernel
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Container
     */
    protected $container;

    public function __construct($debug = false)
    {
        /**
         * debugging
         */
        if ($debug) {
            ErrorHandler::register();
            ExceptionHandler::register();
            DebugClassLoader::enable();
        }
        $this->container = new Container();
    }

    /**
     * @return Response
     */
    public function run()
    {
        $this->request = Request::createFromGlobals();

        try {

            $routing = include __DIR__ . '/../app/routing.php';
            $router = new Router($this->request, $routing);

            return $this->container->call($router->getController(), $router->getAction(), $router->getParameters());
        } catch (ResourceNotFoundException $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            print_r($e);
            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}