<?php
namespace phpunit\Gap\Routing;

use PHPUnit\Framework\TestCase;
use Gap\Routing\RouterBuilder;

class RouterBuilderTest extends TestCase
{
    public function testBuild(): void
    {
        $buildRouter = $this->createRouteBuilder();

        $router = $buildRouter->build();
        $route = $router->dispatch('www', 'GET', '/a/asdfg1234');

        $this->assertEquals('fetchArticle', $route->name);
        $this->assertEquals('www', $route->site);
        $this->assertEquals('article', $route->app);
        $this->assertEquals('asdfg1234', $route->getParam('zcode'));

        $cacheFile = $this->getCacheFile();
        if (!file_exists($cacheFile)) {
            throw new \Exception('cannot find cache file: ' . $cacheFile);
        }
        unlink($cacheFile);
    }

    public function testBuildWitchCache(): void
    {
        $this->createRouteBuilder()->build();

        $buildRouter = new \Gap\Routing\RouterBuilder(
            dirname(__DIR__),
            []
        );
        $buildRouter
            ->setCacheFile('cache/setting-router-http.php');

        $router = $buildRouter->build();
        $route = $router->dispatch('www', 'GET', '/a/asdfg1234');

        $this->assertEquals('fetchArticle', $route->name);
        $this->assertEquals('www', $route->site);
        $this->assertEquals('article', $route->app);
        $this->assertEquals('article', $route->getApp());
        $cacheFile = $this->getCacheFile();
        if (!file_exists($cacheFile)) {
            throw new \Exception('cannot find cache file: ' . $cacheFile);
        }
        unlink($cacheFile);
    }

    private function createRouteBuilder()
    {
        $baseDir = dirname(__DIR__);
        $buildRouter = new \Gap\Routing\RouterBuilder(
            $baseDir,
            [
                'article' => ['dir' => 'phpunit/router/article'],
                'commit' => ['dir' => 'phpunit/router/commit']
            ]
        );

        $cacheFile  = $this->getCacheFile();
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
        $buildRouter
            ->setCacheFile('cache/setting-router-http.php');
        return $buildRouter;
    }

    private function getCacheFile(): string
    {
        $baseDir = dirname(__DIR__);
        return  $baseDir . '/cache/setting-router-http.php';
    }
}
