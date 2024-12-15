<?php

namespace HefestoMVC\helpers;

class SessionHelper
{
    /**
     * Inicializa a sessão, caso ainda não esteja ativa.
     */
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Define um valor na sessão.
     *
     * @param string $key
     * @param mixed $value
     */
    public static function setSession(string $key, mixed $value): void
    {
        self::startSession();
        $_SESSION[$key] = $value;
    }

    /**
     * Obtém um valor da sessão.
     *
     * @param string $key
     * @param mixed $default Valor padrão caso a chave não exista.
     * @return mixed
     */
    public static function getSession(string $key, mixed $default = null): mixed
    {
        self::startSession();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Remove um valor da sessão.
     *
     * @param string $key
     */
    public static function unsetSession(string $key): void
    {
        self::startSession();
        unset($_SESSION[$key]);
    }

    /**
     * Destroi a sessão completamente.
     */
    public static function destroySession(): void
    {
        self::startSession();
        session_destroy();
    }
}