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

        switch ($res[0]) {
            case Dispatcher::NOT_FOUND:
                throw new \Exception('route not found');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new \Exception('route method not allowed');
                break;
            case Dispatcher::FOUND:
                $route = $this->routeMap[$res[1]['name']][$res[1]['mode']][$res[1]['method']];
                $route->setParams($res[2]);
                return $route;
        }
    }

    public function getRoute(
        string $name,
        array $params = [],
        string $mode = '',
        string $method = ''
    ): Route {
        $modes = $mode ? [$mode] : ['ui', 'rest', 'open'];
        $methods = $method ? [$method] : ['GET', 'POST'];

        if ($set = $this->routeMap[$name] ?? null) {
            foreach ($modes as $mode) {
                if ($sons = $set[$mode] ?? null) {
                    foreach ($methods as $method) {
                        if ($route = $sons[$method] ?? null) {
                            $route->setParams($params);
                            return $route;
                        }
                    }
                }
            }
        }
    }

    protected function getDispatcher($site): Dispatcher
    {
        if (!$this->dispatchDataMap[$site]) {
            throw new \Exception("No route in site[$site]");
        }
        return new Dispatcher($this->dispatchDataMap[$site]);
    }
}
