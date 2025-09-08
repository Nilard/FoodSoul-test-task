<?php

namespace App\Core;

class Router
{
    /**
     * The prefix of the API routes.
     *
     * @var string
     */
    const API_PREFIX = 'api/v1';

    /**
     * The routes of the application.
     *
     * @var array
     */
    private array $webRoutes = [];

    /**
     * The API routes of the application.
     *
     * @var array
     */
    private array $apiRoutes = [];

    /**
     * Construct the router.
     */
    public function __construct()
    {
        $routes = include dirname(__DIR__) . '/routes.php';
        $this->webRoutes = $routes['web'] ?? [];
        $this->apiRoutes = $routes['api']['v1'] ?? [];
    }

    /**
     * Dispatch the request.
     *
     * @return void
     */
    public function dispatch(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        if ($uri !== '/') {
            $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        }
        if (str_starts_with($uri, self::API_PREFIX)) {
            $uri = str_replace(self::API_PREFIX . '/', '', $uri);
            $route = $this->apiRoutes[$uri];
        } else {
            $route = $this->webRoutes[$uri];
        }
        if (!$route) {
            $this->notFound();
            return;
        }
        $params = $_REQUEST;
        $this->callAction($route, $params);
    }

    /**
     * Call the action of the route.
     *
     * @param string $route
     *   The route of the action.
     * @param array $params
     *   The params of the action.
     *
     * @return void
     */
    private function callAction(string $route, array $params = []): void
    {
        list($controller, $action) = explode('@', $route);
        $controller = 'App\\Controllers\\' . $controller;
        $controller = new $controller();
        $controller->$action($params);
    }

    /**
     * 404 not found.
     *
     * @return void
     */
    private function notFound(): void
    {
        http_response_code(404);
    }
}
