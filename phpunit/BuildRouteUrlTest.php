<?php
namespace phpunit\Gap\Routing;

use PHPUnit\Framework\TestCase;
use Gap\Routing\BuildRouter;
use Gap\Routing\BuildRouteUrl;
use Gap\Routing\BuildSiteUrl;
use Gap\Routing\SiteManager;
use Gap\Routing\Router;

class BuildRouteUrlTest extends TestCase
{
    public function testRouteUrl(): void
    {
        $buildUrl = new BuildRouteUrl($this->getRouter(), $this->getBuildSiteUrl());
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
        $buildUrl = new BuildRouteUrl($this->getRouter(), $this->getBuildSiteUrl(), 'zh-cn');
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

        $buildUrl->setLocale('en-us');
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
        $buildUrl = new BuildRouteUrl($this->getRouter(), $this->getBuildSiteUrl());
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
        $buildSiteUrl = $this->getBuildSiteUrl();
        $url = $buildSiteUrl->staticUrl('/a/b/c', ['v' => '321', 'd' => 'now']);

        $this->assertEquals(
            '//static.gaptree.com/a/b/c?v=321&d=now',
            $url
        );
    }

    protected function getRouter(): Router
    {
        $buildRouter = new \Gap\Routing\BuildRouter(
            dirname(__DIR__),
            []
        );
        $buildRouter
            ->setCacheFile('cache/setting-router-http.php');

        $router = $buildRouter->build();
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

    protected function getBuildSiteUrl(): BuildSiteUrl
    {
        return new BuildSiteUrl($this->getSiteManager());
    }
}
