<?php

/**
 * Database Connection Handler
 * Compatible with PHP 5.6+ and Hostinger shared hosting
 */
class Database
{
    private static $connection = null;
    private static $config;

    /**
     * Get database connection (Singleton)
     */
    public static function getConnection()
    {
        if (self::$connection === null) {
            self::connect();
        }
        return self::$connection;
    }

    /**
     * Establish database connection
     */
    private static function connect()
    {
        self::$config = require __DIR__ . '/../config/database.php';

        try {
            $dsn = sprintf(
                "mysql:host=%s;dbname=%s;charset=%s",
                self::$config['host'],
                self::$config['database'],
                self::$config['charset']
            );

            self::$connection = new PDO(
                $dsn,
                self::$config['username'],
                self::$config['password'],
                self::$config['options']
            );
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Veritabanı bağlantısı kurulamadı. Lütfen sistem yöneticisiyle iletişime geçin.");
        }
    }

    /**
     * Execute a query and return all results
     */
    public static function query($sql, $params = array())
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Execute a query and return first result
     */
    public static function queryOne($sql, $params = array())
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ? $result : null;
    }

    /**
     * Execute an insert/update/delete query
     */
    public static function execute($sql, $params = array())
    {
        $stmt = self::getConnection()->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Get last inserted ID
     */
    public static function lastInsertId()
    {
        return self::getConnection()->lastInsertId();
    }

    /**
     * Begin transaction
     */
    public static function beginTransaction()
    {
        return self::getConnection()->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public static function commit()
    {
        return self::getConnection()->commit();
    }

    /**
     * Rollback transaction
     */
    public static function rollback()
    {
        return self::getConnection()->rollBack();
    }
}
