<?php

namespace HefestoMVCLibrary;

use Exception;
use HefestoMVC\midlewares\AuthMiddleware;
use HefestoMVC\midlewares\AdminMiddleware;
use HefestoMVC\midlewares\VerifiedMiddleware;

class MiddlewareHandler
{
    protected static array $middlewareMap = [
        'admin' => AdminMiddleware::class,
        'auth'   => AuthMiddleware::class,
        'verified' => VerifiedMiddleware::class,
    ];

    public static function handle(array $middlewares)
    {
        foreach ($middlewares as $middleware) {
            $middlewareClass = self::$middlewareMap[$middleware] ?? null;

            if (!$middlewareClass || !class_exists($middlewareClass)) {
                throw new Exception("Middleware class {$middleware} not found: ");
            }

            $instance = new $middlewareClass();
            $instance->handle();
        }
    }
}