<?php
namespace phpunit\Gap\Routing;

use PHPUnit\Framework\TestCase;
use Gap\Routing\BuildRouter;

class BuildRouterTest extends TestCase
{
    public function testBuild(): void
    {
        $buildRouter = new \Gap\Routing\BuildRouter(
            dirname(__DIR__),
            [
                'article' => ['dir' => 'phpunit/router/article'],
                'commit' => ['dir' => 'phpunit/router/commit']
            ]
        );
        /*
        keep it
        if ($debug) {
            $buildRouter
                ->setCacheFile('cache/setting-router-http.php');
        }
        */

        $router = $buildRouter->build();
        $route = $router->dispatch('www', 'GET', '/a/asdfg1234');

        $this->assertEquals('fetchArticle', $route->name);
        $this->assertEquals('www', $route->site);
        $this->assertEquals('article', $route->app);
        $this->assertEquals('asdfg1234', $route->getParam('zcode'));
    }

    public function testBuildWitchCache(): void
    {
        $buildRouter = new \Gap\Routing\BuildRouter(
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
