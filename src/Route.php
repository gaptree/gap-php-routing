<?php
namespace Gap\Routing;

class Route implements \JsonSerializable
{
    public $status; // deprecated
    public $name;
    public $action;
    public $site;
    public $app;
    public $mode;
    public $access;
    public $params;
    public $pattern;
    public $method;

    public static function __set_state(array $data)
    {
        return new Route($data);
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    public function __construct(array $data)
    {
        $this->site = $data['site'] ?? '';
        $this->app = $data['app'] ?? '';
        $this->access = $data['access'] ?? '';

        $this->method = $data['method'];
        $this->status = $data['status'] ?? 0;
        $this->name = $data['name'] ?? '';
        $this->action = $data['action'];
        $this->mode = $data['mode'] ?? 'ui';
        $this->params = $data['params'] ?? [];
        $this->pattern = $data['pattern'];

        if (empty($this->name)) {
            throw new \Exception('route name could not be empty');
        }
        if (empty($this->site)) {
            throw new \Exception('route site could not be empty');
        }
        if (empty($this->access)) {
            throw new \Exception('route access could not be empty');
        }
        if (empty($this->app)) {
            throw new \Exception('route app could not be empty');
        }
    }

    public function getParam(string $key): string
    {
        return $this->params[$key] ?? '';
    }

    public function setParam(string $key, string $val): self
    {
        $this->params[$key] = $val;
        return $this;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function getPath(): string
    {
        $pattern = $this->pattern;
        $params = $this->params;
        if ($params) {
            $pattern = $this->pregReplaceSub(
                '/\{.*?\}/',
                $params,
                $this->replaceNamedParameters($pattern, $params)
            );
        }
        return str_replace(['[', ']'], '', preg_replace('/\{.*?\?\}/', '', $pattern));
    }

    protected function pregReplaceSub($pattern, &$replacements, $subject)
    {
        return preg_replace_callback($pattern, function () use (&$replacements) {
            return array_shift($replacements);
        }, $subject);
    }

    protected function replaceNamedParameters($pattern, &$params)
    {
        return preg_replace_callback('/\{(.*?)\??\}/', function ($match) use (&$params) {
            return isset($params[$match[1]]) ? $this->arrPull($params, $match[1]) : $match[0];
        }, $pattern);
    }

    protected function arrPull(&$arr, $key, $default = null)
    {
        $val = $arr[$key] ?? $default;
        if (isset($arr[$key])) {
            unset($arr[$key]);
        }
        return $val;
    }

    // deprecated
    // use $route->var insteand of $route->getVar

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getSite(): string
    {
        return $this->site;
    }

    public function getApp(): string
    {
        return $this->app;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function getAccess(): string
    {
        return $this->access;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
