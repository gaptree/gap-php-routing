<?php
namespace Gap\Routing;

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
        string $protocol = '',
        string $mode = '',
        string $method = ''
    ): string {
        $route = $this->router->getRoute($name, $params, $mode, $method);
        $localeSlug = $this->localeKey ? '/' . $this->localeKey : '';

        return $this->siteUrlBuilder->url(
            $route->site,
            $localeSlug . $route->getPath(),
            $query,
            $protocol
        );
    }

    public function routePost($name, $params = [], $query = [], $protocol = '')
    {
        return $this->routeUrl($name, $params, $query, $protocol, 'ui', 'POST');
    }

    public function routeGet($name, $params = [], $query = [], $protocol = '')
    {
        return $this->routeUrl($name, $params, $query, $protocol, 'ui', 'GET');
    }

    public function routePostRest($name, $params = [], $query = [], $protocol = '')
    {
        return $this->routeUrl($name, $params, $query, $protocol, 'rest', 'POST');
    }

    public function routeGetRest($name, $params = [], $query = [], $protocol = '')
    {
        return $this->routeUrl($name, $params, $query, $protocol, 'rest', 'GET');
    }
}
