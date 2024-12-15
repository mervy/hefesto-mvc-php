<?php

namespace App\Helpers;

class CookieHelper
{
    /**
     * Define um cookie.
     *
     * @param string $key
     * @param string $value
     * @param int $expire Tempo de expiração em segundos (padrão: 1 hora).
     * @param string $path Caminho válido para o cookie (padrão: '/').
     */
    public static function setCookie(string $key, string $value, int $expire = 3600, string $path = '/'): void
    {
        setcookie($key, $value, time() + $expire, $path);
    }

    /**
     * Obtém um valor de um cookie.
     *
     * @param string $key
     * @param mixed $default Valor padrão caso o cookie não exista.
     * @return mixed
     */
    public static function getCookie(string $key, mixed $default = null): mixed
    {
        return $_COOKIE[$key] ?? $default;
    }

    /**
     * Remove um cookie.
     *
     * @param string $key
     * @param string $path Caminho válido para o cookie (padrão: '/').
     */
    public static function unsetCookie(string $key, string $path = '/'): void
    {
        setcookie($key, '', time() - 3600, $path);
    }
}