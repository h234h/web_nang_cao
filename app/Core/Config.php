<?php
// app/Core/Config.php
class Config
{
    const DB_HOST = "localhost";
    const DB_NAME = "nghe_lai";
    const DB_USER = "root";
    const DB_PASS = "";
    const BASE_URL = "http://localhost/web_nc/public/";

    public static function get($key)
    {
        return constant("self::$key");
    }
}
