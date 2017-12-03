<?php
namespace Gap\Routing;

class SiteManager
{
    protected $siteMap = [];
    protected $hostMap = [];

    public function __construct(array $siteMap)
    {
        $this->siteMap = $siteMap;
    }

    public function getSite(string $host): string
    {
        $hostMap = $this->getHostMap();

        if (!isset($hostMap[$host])) {
            // todo
            throw new \Exception("cannot find host $host");
        }

        return $hostMap[$host];
    }

    public function getHost(string $site): string
    {
        return $this->siteMap[$site]['host'];
    }

    protected function getHostMap(): array
    {
        if ($this->hostMap) {
            return $this->hostMap;
        }

        foreach ($this->siteMap as $site => $opts) {
            $this->hostMap[$opts['host']] = $site;
        }

        return $this->hostMap;
    }
}
