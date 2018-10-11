<?php
namespace Gap\Routing;

use FastRoute\RouteParser\Std as RouteParser;
use FastRoute\RouteCollector as FastRouteCollector;
use FastRoute\DataGenerator\GroupCountBased as DataGenerator;

class RouteCollectionLoader
{
    protected $fastRouteCollectors = [];
    protected $routeMap = [];

    public function loadCollection(RouteCollection $collection, string $appName = ''): void
    {
        foreach ($collection->all() as $opts) {
            $opts['app'] = $appName;
            $this->addRoute($opts);
        }
    }

    public function requireFile(string $file, string $appName): self
    {
        $this->loadCollection(require $file, $appName);
        return $this;
    }

    public function requireDir(string $dir, string $appName): self
    {
        if (!file_exists($dir)) {
            throw new \Exception('Cannot find dir: ' . $dir);
        }

        $scaned = scandir($dir);

        if (is_array($scaned)) {
            foreach ($scaned as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) == 'php') {
                    $this->requireFile($dir . '/' . $file, $appName);
                }
            }
        }

        return $this;
    }

    public function getRouteMap(): array
    {
        return $this->routeMap;
    }

    public function getDispatchDataMap(): array
    {
        $dispatchDataMap = [];
        foreach ($this->fastRouteCollectors as $site => $fastRouteCollector) {
            $dispatchDataMap[$site] = $fastRouteCollector->getData();
        }
        return $dispatchDataMap;
    }

    public function getRouterData(): array
    {
        return [
            'routeMap' => $this->getRouteMap(),
            'dispatchDataMap' => $this->getDispatchDataMap(),
        ];
    }

    protected function addRoute(array $opts): void
    {
        if (!isset($opts['site'])) {
            throw new \Exception('site not found');
        }
        if (!isset($opts['app'])) {
            throw new \Exception('app not fond');
        }
        if (!isset($opts['access'])) {
            throw new \Exception('access not found');
        }
        $route = new Route($opts);


        $fastRouteCollector = $this->getFastRouteCollector($route->getSite());
        $fastRouteCollector->addRoute(
            $route->getMethod(),
            $route->getPattern(),
            [
                'name' => $route->getName(),
                'mode' => $route->getMode(),
                'method' => $route->getMethod()
            ]
        );
        $this->routeMap[$route->getName()][$route->getMode()][$route->getMethod()] = $route;
    }

    protected function getFastRouteCollector($site): FastRouteCollector
    {
        if (!isset($this->fastRouteCollectors[$site])) {
            $this->fastRouteCollectors[$site] = new FastRouteCollector(
                new RouteParser(),
                new DataGenerator()
            );
        }

        return $this->fastRouteCollectors[$site];
    }
}
