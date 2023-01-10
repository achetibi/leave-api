<?php

/**
 * Database configuration
 *
 * @return array
 */

return [
    'host' => getenv('DB_HOST'),
    'port' => getenv('DB_PORT'),
    'database' => getenv('DB_NAME'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD')
];
