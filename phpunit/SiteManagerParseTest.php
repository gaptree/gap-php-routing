<?php
namespace phpunit\Gap\Routing;

use Gap\Routing\SiteManager;
use PHPUnit\Framework\TestCase;

class SiteManagerParseTest extends TestCase
{
    public function testSiteHost(): void
    {
        $siteManager = new SiteManager([
            'front' => [
                'baseUrl' => 'www.gaptree.com/web'
            ],
            'api' => [
                'baseUrl' => 'www.gaptree.com/api'
            ],
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
        $this->assertEquals(
            'www.gaptree.com',
            $siteManager->getBaseUrl('www')
        );
        $this->assertEquals(
            'www.gaptree.com/web',
            $siteManager->getBaseUrl('front')
        );
        $this->assertEquals(
            'www',
            $siteManager->getSite('www.gaptree.com')
        );
        $this->assertEquals(
            ['front', '/hello/world'],
            $siteManager->parse('www.gaptree.com/web/hello/world')
        );
        $this->assertEquals(
            ['www', '/some/url-path'],
            $siteManager->parse('www.gaptree.com/some/url-path')
        );
        $this->assertEquals(
            ['', ''],
            $siteManager->parse('www.notexist.com/some/url-path')
        );
    }
}
