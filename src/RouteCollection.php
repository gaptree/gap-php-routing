<?php
namespace Gap\Routing;

class RouteCollection
{
    protected $routeOptsAsm = [];

    protected $app;
    protected $site;
    protected $access;

    public function app(string $app): self
    {
        $this->app = $app;
        return $this;
    }

    public function site(string $site): self
    {
        $this->site = $site;
        return $this;
    }

    public function access(string $access): self
    {
        $this->access = $access;
        return $this;
    }

    public function all(): array
    {
        return $this->routeOptsAsm;
    }

    public function addRoute(array $opts): self
    {
        if (!isset($opts['site'])) {
            $opts['site'] = $this->site;
        }
        if (!isset($opts['access'])) {
            $opts['access'] = $this->access;
        }
        if (!isset($opts['app'])) {
            $opts['app'] = $this->app;
        }

        $this->routeOptsAsm[] = $opts;
        return $this;
    }

    public function get(string $pattern, string $name, string $action): self
    {
        $this->addRoute([
            'method' => 'GET',
            'pattern' => $pattern,
            'name' => $name,
            'action' => $action
        ]);
        return $this;
    }

    public function post(string $pattern, string $name, string $action): self
    {
        $this->addRoute([
            'method' => 'POST',
            'pattern' => $pattern,
            'name' => $name,
            'action' => $action
        ]);
        return $this;
    }

    public function getRest(string $pattern, string $name, string $action): self
    {
        $this->addRoute([
            'method' => 'GET',
            'pattern' => $pattern,
            'mode' => 'rest',
            'name' => $name,
            'action' => $action
        ]);
        return $this;
    }

    public function postRest(string $pattern, string $name, string $action): self
    {
        $this->addRoute([
            'method' => 'POST',
            'pattern' => $pattern,
            'mode' => 'rest',
            'name' => $name,
            'action' => $action
        ]);
        return $this;
    }

    public function getOpen(string $pattern, string $name, string $action): self
    {
        $this->addRoute([
            'method' => 'GET',
            'pattern' => $pattern,
            'mode' => 'open',
            'name' => $name,
            'action' => $action
        ]);
        return $this;
    }

    public function postOpen(string $pattern, string $name, string $action): self
    {
        $this->addRoute([
            'method' => 'POST',
            'pattern' => $pattern,
            'mode' => 'open',
            'name' => $name,
            'action' => $action
        ]);
        return $this;
    }
}
