<?php

namespace HefestoMVCLibrary;

class Route
{
    private static array $routes = [];
    private array $middleware = [];

    public function __construct(private string $method, private string $uri, private $action) {}

    public static function get(string $uri, $action)
    {
        return self::addRoute('GET', $uri, $action);
    }

    public static function post(string $uri,  $action)
    {
        return self::addRoute('POST', $uri, $action);
    }

    private static function addRoute(string $method, string $uri, $action)
    {
        $route = new self($method, $uri, $action);
        self::$routes[] = $route;
        return $route;
    }

    public function middleware($middleware)
    {
        $this->middleware = is_array($middleware) ? $middleware : [$middleware];
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public function matches(string $requestUri, string $requestMethod)
    {
        if ($this->method !== $requestMethod) {
            return false;
        }
        $baseUri = strtok($requestUri, '?');
        $pattern = preg_replace('/\{[^\}]+\}/', '([^/]+)', $this->uri);
        return preg_match("#^{$pattern}$#", $baseUri);
    }

    public function extractParameters(string $requestUri)
    {
        $baseUri = strtok($requestUri, '?');
        $pattern = preg_replace('/\{[^\}]+\}/', '([^/]+)', $this->uri);
        preg_match("#^{$pattern}$#", $baseUri, $matches);
    
        // Extrair os nomes dos parâmetros
        preg_match_all('/\{([^\}]+)\}/', $this->uri, $paramNames);
    
        $params = [];
        if (!empty($paramNames[1])) {
            foreach ($paramNames[1] as $index => $name) {
                $params[$name] = $matches[$index + 1] ?? null; // Ignorar o primeiro match (base URI)
            }
        }
    
        // Inclui parâmetros da query string
        $queryString = [];
        $query = parse_url($requestUri, PHP_URL_QUERY) ?? '';
        parse_str($query, $queryString);
    
        return array_merge($params, $queryString);
    }
    
    

    public function getAction()
    {
        return $this->action;
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }
}