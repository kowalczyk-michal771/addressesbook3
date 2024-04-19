<?php

namespace Src\Routing;

use Src\DependencyInjection\Container;

class Router
{
    private array $routes = [];
    private Container $container;

    /**
     * Router constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $method
     * @param string $path
     * @param string $controllerClass
     * @param string $function
     */
    public function register(
        string $method,
        string $path,
        string $controllerClass,
        string $function
    )
    {
        $this->routes[$method][$path] = [$controllerClass, $function];
    }

    /**
     * @param string $method
     * @param string $path
     * @throws \Exception
     */
    public function route(string $method, string $path): void
    {
        if (isset($this->routes[$method][$path])) {
            [$controllerClass, $function] = $this->routes[$method][$path];
            $controller = $this->container->get($controllerClass);

            $params = $method === 'POST' ? $_POST : $_GET;

            $refMethod = new \ReflectionMethod($controller, $function);
            $args = [];
            foreach ($refMethod->getParameters() as $param) {
                $paramName = $param->getName();
                $args[] = $params[$paramName] ?? ($param->isDefaultValueAvailable() ? $param->getDefaultValue() : null);
            }

            call_user_func_array([$controller, $function], $args);
        } else {
            header("HTTP/1.0 404 Not Found");
            throw new \Exception("Page not found");
        }
    }
}