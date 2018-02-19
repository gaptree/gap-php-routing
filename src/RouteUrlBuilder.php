<?php
namespace Gap\Routing;

use Gap\Http\SiteUrlBuilder;

class RouteUrlBuilder
{
    protected $router;
    protected $localeKey;
    protected $siteUrlBuilder;

    public function __construct(
        Router $router,
        SiteUrlBuilder $siteUrlBuilder,
        string $localeKey = ''
    ) {
        $this->router = $router;
        $this->siteUrlBuilder = $siteUrlBuilder;
        $this->localeKey = $localeKey;
    }

    public function setLocaleKey(string $localeKey): void
    {
        $this->localeKey = $localeKey;
    }

    public function routeUrl(
        string $name,
        array $params = [],
        array $query = [],
        array $opts = []
    ): string {
        $protocol = $opts['protocol'] ?? '';
        $mode = $opts['mode'] ?? '';
        $method = $opts['method'] ?? '';
        $localeKey = $opts['localeKey'] ?? '';

        $route = $this->router->getRoute($name, $params, $mode, $method);
        $localeKey = $localeKey ? $localeKey : $this->localeKey;
        $localeSlug = $localeKey ? '/' . $localeKey : '';

        return $this->siteUrlBuilder->url(
            $route->site,
            $localeSlug . $route->getPath(),
            $query,
            $protocol
        );
    }

    public function routePost($name, $params = [], $query = [], $opts = [])
    {
        $opts['mode'] = 'ui';
        $opts['method'] = 'POST';
        return $this->routeUrl($name, $params, $query, $opts);
    }

    public function routeGet($name, $params = [], $query = [], $opts = [])
    {
        $opts['mode'] = 'ui';
        $opts['method'] = 'GET';
        return $this->routeUrl($name, $params, $query, $opts);
    }

    public function routePostRest($name, $params = [], $query = [], $opts = [])
    {
        $opts['mode'] = 'rest';
        $opts['method'] = 'POST';
        return $this->routeUrl($name, $params, $query, $opts);
    }

    public function routeGetRest($name, $params = [], $query = [], $opts = [])
    {
        $opts['mode'] = 'rest';
        $opts['method'] = 'GET';
        return $this->routeUrl($name, $params, $query, $opts);
    }

    public function routePostOpen($name, $params = [], $query = [], $opts = [])
    {
        $opts['mode'] = 'open';
        $opts['method'] = 'POST';
        return $this->routeUrl($name, $params, $query, $opts);
    }

    public function routeGetOpen($name, $params = [], $query = [], $opts = [])
    {
        $opts['mode'] = 'open';
        $opts['method'] = 'GET';
        return $this->routeUrl($name, $params, $query, $opts);
    }
}
