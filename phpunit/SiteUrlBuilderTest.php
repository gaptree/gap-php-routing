<?php
namespace phpunit\Gap\Routing;

use PHPUnit\Framework\TestCase;

use Gap\Routing\SiteUrlBuilder;
use Gap\Routing\SiteManager;

class SiteUrlBuilderTest extends TestCase
{
    protected $siteManager;
    protected $siteUrlBuilder;

    protected function setUp(): void
    {
        $this->siteManager = new SiteManager([
            'www' => [
                'host' => 'www.gaptree.com',
            ],
            'front' => [
                'host' => 'www.gaptree.com/web',
            ],
            'static' => [
                'host' => 'static.gaptree.com',
                'dir' => '%baseDir%/site/static',
            ],
            'i' => [
                'host' => 'i.gaptree.com'
            ]
        ]);
        $this->siteUrlBuilder = new SiteUrlBuilder($this->siteManager);
    }

    public function testUrl(): void
    {
        $this->assertEquals(
            'https://www.gaptree.com/a/b/c',
            $this->siteUrlBuilder->url(
                'www',
                '/a/b/c',
                [],
                'https://'
            )
        );
        $this->assertEquals(
            'https://www.gaptree.com/web/a/b/c',
            $this->siteUrlBuilder->url(
                'front',
                '/a/b/c',
                [],
                'https://'
            )
        );
    }

    public function testStaticUrl(): void
    {
        $url = $this->siteUrlBuilder->staticUrl('/a/b/c', ['v' => '321', 'd' => 'now']);
        $this->assertEquals(
            '//static.gaptree.com/a/b/c?v=321&d=now',
            $url
        );
    }
}
