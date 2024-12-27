<?php

require_once 'config/database.php';


class Model
{
    protected static $db;

    protected static function getDb()
    {
        if (!self::$db) {
            self::$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (self::$db->connect_error) {
                die("Database connection error: " . self::$db->connect_error);
            }
        }
        return self::$db;
    }
}
?>