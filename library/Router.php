<?php

namespace HefestoMVCLibrary;

use Exception;
use HefestoMVC\controllers\NotFoundController;
use ReflectionMethod;

class Router
{
    public function dispatch(string $requestUri, string $requestMethod)
    {
        foreach (Route::getRoutes() as $route) {
            if ($route->matches($requestUri, $requestMethod)) {
                // Extrair os parâmetros da URL (parâmetros de rota)
                $params = $route->extractParameters($requestUri);

                // Middleware handling (se necessário)
                MiddlewareHandler::handle($route->getMiddleware());

                $action = $route->getAction();

                if (is_array($action)) {
                    [$controller, $method] = $action;

                    // Resolver o controlador usando o Container
                    $controllerInstance = Container::get($controller);

                    // Usar ReflectionMethod para obter os parâmetros da função
                    $reflectionMethod = new ReflectionMethod($controllerInstance, $method);

                    // Criar um array para armazenar os valores dos parâmetros
                    $methodParams = [];

                    foreach ($reflectionMethod->getParameters() as $param) {
                        $paramName = $param->getName();
                    
                        if (array_key_exists($paramName, $params)) {
                            $methodParams[] = $params[$paramName];
                        } elseif ($param->isOptional()) {
                            $methodParams[] = $param->getDefaultValue();
                        } else {
                            throw new Exception("Parâmetro não fornecido: " . $paramName);
                        }
                    }
                    

                    // Chamada da função com os parâmetros certos
                    return $controllerInstance->$method(...$methodParams);
                }

                if (is_callable($action)) {
                    return $action($params);
                }
            }
        }

        $this->handleNotFound();
    }

    private function handleNotFound()
    {
        http_response_code(404);
        $controller = new NotFoundController();
        if (method_exists($controller, 'index')) {
            return $controller->index();
        }

        throw new Exception("NotFoundController ou método 'index' não implementado.");
    }
}