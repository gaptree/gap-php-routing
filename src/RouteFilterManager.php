<?php
namespace Gap\Routing;

use Gap\Http\Request;

class RouteFilterManager
{
    protected $filters = [];

    public function filter(Request $request, Route $route): void
    {
        foreach ($this->filters as $filter) {
            $filter->setRequest($request);
            $filter->setRoute($route);
            $filter->filter();
        }
    }

    public function addFilter(RouteFilterBase $routeFilter): self
    {
        $this->filters[] = $routeFilter;
        return $this;
    }
}
