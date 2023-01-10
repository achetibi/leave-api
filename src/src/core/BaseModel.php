<?php

namespace App\core;

class BaseModel
{
    /**
     * @var \PDO
     */
    private static $db;

    /**
     * @return \PDO
     */
    public static function db()
    {
        if (static::$db === null) {
            static::$db = (new Database())->connection();
        }

        return static::$db;
    }
}
