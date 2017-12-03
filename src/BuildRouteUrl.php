<?php
namespace Gap\Routing;

class BuildRouteUrl
{
    protected $router;
    protected $locale;
    protected $buildSiteUrl;

    public function __construct(Router $router, BuildSiteUrl $buildSiteUrl, string $locale = '')
    {
        $this->router = $router;
        $this->buildSiteUrl = $buildSiteUrl;
        $this->locale = $locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
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
        $localeSlug = $this->locale ? '/' . $this->locale : '';

        return $this->buildSiteUrl->url(
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
