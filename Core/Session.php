<?php


namespace Core;


class Session
{
    const FIELD_USER_ID = 'user_id';

    private function __construct()
    {
        session_start();
    }

    public static function instance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    private function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function destroy()
    {
        session_destroy();
    }

}