<?php
namespace Gap\Routing;

class SiteUrlBuilder
{
    protected $siteManager;

    public function __construct(SiteManager $siteManager)
    {
        $this->siteManager = $siteManager;
    }

    public function url(string $site, string $path, array $query = [], string $protocol = '//'): string
    {
        // $protocol: http:// | https:// | //
        $protocol = $protocol ? $protocol : '//';

        $host = $this->siteManager->getHost($site);
        if ($path[0] !== '/') {
            $path = '/' . $path;
        }

        return $protocol . $host . $path
            . ($query ? ('?' . http_build_query($query)) : '');
    }

    public function staticUrl(string $path, array $query = [], string $protocol = ''): string
    {
        return $this->url('static', $path, $query, $protocol);
    }

    public function imgSrc($imgArr, $size = '', $protocol = '')
    {
        $sizeMap = [
            'small' => '?imageView&thumbnail=100y72&enlarge=1',
            'cover' => '?imageView&thumbnail=200y123&enlarge=1',
            'large' => '?imageView&thumbnail=600y369&enlarge=1',
            'origin' => ''
        ];

        if ($imgArr) {
            $path = "{$imgArr->dir}/{$imgArr->name}.{$imgArr->ext}{$sizeMap[$size]}";
            return $this->url($imgArr->site, $path, [], $protocol);
        }

        return null;
    }
}
