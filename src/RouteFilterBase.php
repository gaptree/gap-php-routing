<?php
namespace Gap\Routing;

use Gap\Http\Request;

abstract class RouteFilterBase
{
    protected $request;
    protected $route;

    public function setRoute(Route $route): void
    {
        $this->route = $route;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    abstract public function filter(): void;
}
