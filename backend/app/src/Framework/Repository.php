<?php

namespace App\Framework;

use App\Config;
use PDO;

class Repository 
{
    private static ?PDO $connection = null;

    public function __construct()
    {
        if (self::$connection === null) {
            try {
                $connectionString = 'mysql:host=' . Config::DB_SERVER_NAME . ';dbname=' . 
                       Config::DB_NAME . ";charset=utf8mb4"; 
                
                self::$connection = new PDO(
                    $connectionString, 
                    Config::DB_USERNAME, 
                    Config::DB_PASSWORD,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );   
            } catch (\PDOException $e) {
                error_log($e->getMessage());
                throw new \Exception("Database connection error.");
            }
        }
    }

    public function getConnection(): PDO 
    {
        return self::$connection;
    }
}