<?php

namespace App\core;

use PDO;
use PDOException;

class Database
{
    private string $dsn;
    private string $username;
    private string $password;

    public function __construct()
    {
        $config = require ROOT_DIRECTORY . '/src/config/database.php';

        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->dsn = "mysql:host={$config['host']};dbname={$config['database']};port={$config['port']}";
    }

    /**
     * @return PDO|void
     */
    public function connection()
    {
        try{
            $connection = new PDO($this->dsn, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        } catch(PDOException $e) {
            echo "Connection error ".$e->getMessage();
            exit;
        }
    }
}
