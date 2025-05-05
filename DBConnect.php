<?php

require_once __DIR__ . '/logger.php';

class DBConnection
{
    private static $pdo   = null;
    private static $host   = 'localhost';
    private static $user   = 'banner_stats_user';
    private static $pass   = 'banner_stats_secret';
    private static $dbName = 'banner_stats';

    private function __construct() {}

    public static function getInstance(): ?PDO
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbName,
                    self::$user,
                    self::$pass,
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]
                );
            } catch (PDOException $e) {
                logMessage("DB Connect error: " . $e->getMessage());		

                http_response_code(500);
            }
        }

        return self::$pdo;
    }

    public function __destruct()
    {
        self::$pdo = null;
    }
}
