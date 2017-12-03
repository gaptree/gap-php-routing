<?php
namespace Gap\Routing;

class BuildRouter
{
    protected $srcOpts;
    protected $baseDir;
    protected $cacheFile = false;

    public function __construct(string $baseDir, array $srcOpts)
    {
        $this->baseDir = $baseDir;
        $this->srcOpts = $srcOpts;
    }

    public function setCacheFile(string $cacheFile): void
    {
        $this->cacheFile = $cacheFile[0] === '/' ? $cacheFile : $this->baseDir . '/' . $cacheFile;
    }

    public function build(): Router
    {
        $router = new Router();

        if ($this->cacheFile && file_exists($this->cacheFile)) {
            $router->load(require $this->cacheFile);
            return $router;
        }

        $collector = new Collector();
        $collection = new RouteCollection();
        foreach ($this->srcOpts as $appName => $opts) {
            $collection->requireDir($this->baseDir . '/' . $opts['dir'], $appName);
        }
        $collector->loadCollection($collection);

        $routerData = [
            'routeMap' => $collector->getRouteMap(),
            'dispatchDataMap' => $collector->getDispatchDataMap(),
        ];

        if ($this->cacheFile) {
            $this->var2file(
                $this->cacheFile,
                $routerData
            );
        }

        $router->load($routerData);
        return $router;
    }

    protected function var2file(string $targetPath, $var): void
    {
        $writtern = file_put_contents(
            $targetPath,
            '<?php return ' . var_export($var, true) . ';'
        );

        if (false === $writtern) {
            throw new \Exception("Write content to file '$targetPath' failed");
        }
    }
}
