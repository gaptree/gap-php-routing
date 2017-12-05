<?php
namespace phpunit\Gap\Routing;

use PHPUnit\Framework\TestCase;
use Gap\Routing\RouterBuilder;
use Gap\Routing\RouteUrlBuilder;
use Gap\Routing\SiteUrlBuilder;
use Gap\Routing\SiteManager;
use Gap\Routing\Router;

class RouteUrlBuilderTest extends TestCase
{
    public function testRouteUrl(): void
    {
        $buildUrl = new RouteUrlBuilder($this->getRouter(), $this->getSiteUrlBuilder());
        $url = $buildUrl->routeUrl(
            'fetchArticle',
            ['zcode' => 'abc'],
            ['commitId' => 'edf', 'v' => '1234'],
            '',
            'ui',
            'GET'
        );
        $this->assertEquals(
            "//www.gaptree.com/a/abc?commitId=edf&v=1234",
            $url
        );
    }

    public function testRouteUrlWithLocale(): void
    {
        $buildUrl = new RouteUrlBuilder($this->getRouter(), $this->getSiteUrlBuilder(), 'zh-cn');
        $url = $buildUrl->routeUrl(
            'fetchArticle',
            ['zcode' => 'abc'],
            ['commitId' => 'edf', 'v' => '1234'],
            '',
            'ui',
            'GET'
        );
        $this->assertEquals(
            "//www.gaptree.com/zh-cn/a/abc?commitId=edf&v=1234",
            $url
        );

        $buildUrl->setLocaleKey('en-us');
        $url = $buildUrl->routeUrl(
            'fetchArticle',
            ['zcode' => 'abc'],
            ['commitId' => 'edf', 'v' => '1234'],
            '',
            'ui',
            'GET'
        );
        $this->assertEquals(
            "//www.gaptree.com/en-us/a/abc?commitId=edf&v=1234",
            $url
        );
    }

    public function testRoutePost(): void
    {
        $buildUrl = new RouteUrlBuilder($this->getRouter(), $this->getSiteUrlBuilder());
        $url = $buildUrl->routePostRest(
            'updateCommit',
            [],
            ['commitId' => 'edf', 'v' => '5678'],
            'https://'
        );
        $this->assertEquals(
            'https://www.gaptree.com/rest/commit/update?commitId=edf&v=5678',
            $url
        );
    }

    public function testStaticUrl(): void
    {
        $siteUrlBuilder = $this->getSiteUrlBuilder();
        $url = $siteUrlBuilder->staticUrl('/a/b/c', ['v' => '321', 'd' => 'now']);

        $this->assertEquals(
            '//static.gaptree.com/a/b/c?v=321&d=now',
            $url
        );
    }

    protected function getRouter(): Router
    {
        $routerBuilder = new \Gap\Routing\RouterBuilder(
            dirname(__DIR__),
            []
        );
        $routerBuilder
            ->setCacheFile('cache/setting-router-http.php');

        $router = $routerBuilder->build();
        return $router;
    }

    protected function getSiteManager(): SiteManager
    {
        return new SiteManager([
            'www' => [
                'host' => 'www.gaptree.com',
            ],
            'static' => [
                'host' => 'static.gaptree.com',
                'dir' => '%baseDir%/site/static',
            ],
            'i' => [
                'host' => 'i.gaptree.com'
            ]
        ]);
    }

    protected function getSiteUrlBuilder(): SiteUrlBuilder
    {
        return new SiteUrlBuilder($this->getSiteManager());
    }
}
