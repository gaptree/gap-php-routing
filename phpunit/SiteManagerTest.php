<?php
namespace phpunit\Gap\Routing;

use Gap\Routing\SiteManager;
use PHPUnit\Framework\TestCase;

class SiteManagerTest extends TestCase
{
    public function testSiteHost(): void
    {
        $siteManager = new SiteManager([
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
            $siteManager->getHost('www')
        );
        $this->assertEquals(
            'www',
            $siteManager->getSite('www.gaptree.com')
        );
    }
}
