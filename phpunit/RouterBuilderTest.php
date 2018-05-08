<?php
namespace phpunit\Gap\Routing;

use PHPUnit\Framework\TestCase;
use Gap\Routing\RouterBuilder;

class RouterBuilderTest extends TestCase
{
    public function testBuild(): void
    {
        $baseDir = dirname(__DIR__);

        $buildRouter = new \Gap\Routing\RouterBuilder(
            $baseDir,
            [
                'article' => ['dir' => 'phpunit/router/article'],
                'commit' => ['dir' => 'phpunit/router/commit']
            ]
        );

        $cacheFile = $baseDir . '/cache/setting-router-http.php';
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }

        $buildRouter
            ->setCacheFile('cache/setting-router-http.php');

        $router = $buildRouter->build();
        $route = $router->dispatch('www', 'GET', '/a/asdfg1234');

        $this->assertEquals('fetchArticle', $route->name);
        $this->assertEquals('www', $route->site);
        $this->assertEquals('article', $route->app);
        $this->assertEquals('asdfg1234', $route->getParam('zcode'));
    }

    public function testBuildWitchCache(): void
    {
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
    }
}
