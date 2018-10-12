<?php
namespace Gap\Routing;

use FastRoute\DataGenerator\GroupCountBased as DataGenerator;
use FastRoute\Dispatcher\GroupCountBased as Dispatcher;

class Router
{
    protected $routeMap = [];
    protected $dispatchDataMap = [];

    public function load(array $data): void
    {
        $this->routeMap = $data['routeMap'];
        $this->dispatchDataMap = $data['dispatchDataMap'];
    }

    public function clear(): void
    {
        $this->routeMap = [];
        $this->dispatchDataMap = [];
    }

    public function dispatch(string $site, string $method, string $path): Route
    {
        $dispatcher = $this->getDispatcher($site);
        $res = $dispatcher->dispatch($method, $path);

        $flag = $res[0];

        if ($flag === Dispatcher::FOUND) {
            $routeArr = $res[1];
            $params = $res[2];

            $name = $routeArr['name'];
            $mode = $routeArr['mode'];
            $method = $routeArr['method'];

            $route = $this->routeMap[$name][$mode][$method];
            $route->setParams($params);

            return $route;
        }

        if ($flag === Dispatcher::NOT_FOUND) {
            throw new \Exception('route not found');
        }

        if ($flag === Dispatcher::METHOD_NOT_ALLOWED) {
            throw new \Exception('route method not allowed');
        }
    }

    public function allRoute(): array
    {
        $routes = [];
        foreach ($this->routeMap as $set) {
            foreach ($set as $sub) {
                foreach ($sub as $route) {
                    $routes[] = $route;
                }
            }
        }

        return $routes;
    }

    // not recommand
    // todo delete
    /*
    public function allRouteByAccess(string $access): array
    {
        $routes = [];
        foreach ($this->routeMap as $set) {
            foreach ($set as $sub) {
                foreach ($sub as $route) {
                    if ($route->access === $access) {
                        $routes[] = $route;
                    }
                }
            }
        }

        return $routes;
    }
     */

    public function getRoute(
        string $name,
        array $params = [],
        string $mode = '',
        string $method = ''
    ): Route {
        $modes = $mode ? [$mode] : ['ui', 'rest', 'open'];
        $methods = $method ? [$method] : ['GET', 'POST'];

        $set = $this->routeMap[$name] ?? null;
        if (is_null($set)) {
            throw new \Exception("cannot find route $name");
        }

        foreach ($modes as $mode) {
            $sons = $set[$mode] ?? null;
            if (is_null($sons)) {
                continue;
                // to support routeUrl(...)
                //throw new \Exception("cannot find route $name - $mode");
            }

            foreach ($methods as $method) {
                $route = $sons[$method] ?? null;
                if (is_null($route)) {
                    continue;
                    // to support routeUrl(...)
                    //throw new \Exception("cannot find route $name - $mode - $method");
                }

                $route->setParams($params);
                return $route;
            }
        }

        throw new \Exception('unkonw');
    }

    protected function getDispatcher($site): Dispatcher
    {
        if (!isset($this->dispatchDataMap[$site])) {
            throw new \Exception("No route in site[$site]");
        }
        return new Dispatcher($this->dispatchDataMap[$site]);
    }
}
