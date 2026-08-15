<?php


class SessionManager
{
    public static function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


    public static function setSession(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function getSession(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function unsetSession(string $key): void
    {
        unset($_SESSION[$key]);
    }



    public static function destroySession(): void
    {
        session_unset();
        session_destroy();
    }
};