<?php
namespace Gap\Routing;

class SiteManager
{
    private $siteMap = [];
    private $hostMap = [];
    private $baseUrlMap = [];
    private $siteArr = [];
    private $optsArr = [];
    private $regex = '';
    public function __construct(array $siteMap)
    {
        $this->siteMap = $siteMap;
        $regex = '~^(?';
        foreach ($siteMap as $site => $opts) {
            $this->siteArr[] = $site;
            $this->optsArr[] = $opts;
            $host = $opts['host'] ?? '';
            $baseUrl = $opts['baseUrl'] ?? $host;
            $this->hostMap[$host] = $site;
            $this->baseUrlMap[$baseUrl] = $site;
            $regex .= '|(' . $baseUrl . ')(.*)';
        }
        $regex .= ')$~x';
        $this->regex = $regex;
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
    public function parse(string $url): array
    {
        if (!preg_match($this->regex, $url, $matches)) {
            return ['', ''];
        }
        $baseUrl = $matches[1];
        $path = $matches[2];
        $baseUrlMap = $this->getBaseUrlMap();
        return [$baseUrlMap[$baseUrl], $path];
    }
    public function getHost(string $site): string
    {
        return $this->siteMap[$site]['host'] ?? ($this->siteMap[$site]['baseUrl'] ?? '');
    }
    public function getBaseUrl(string $site): string
    {
        return $this->siteMap[$site]['baseUrl'] ?? ($this->siteMap[$site]['host'] ?? '');
    }
    private function getHostMap(): array
    {
        return $this->hostMap;
    }
    private function getBaseUrlMap(): array
    {
        return $this->baseUrlMap;
    }
}
