<?php


class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {

                $host = 'localhost';
                $dbname = 'store';
                $user = 'ousmanesm';
                $password = 'ousmaneSM';

                $dsnPostgres = "pgsql:host=$host;dbname=$dbname;";

                self::$instance = new PDO($dsnPostgres, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_TIMEOUT => 10
                ]);
            } catch (PDOException $e) {

                $dbPath = dirname(dirname(__DIR__)) . '/erp.db';
                $dsnSQLite = "sqlite:" . $dbPath;

                self::$instance = new PDO($dsnSQLite, null, null, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            }
        }

        return self::$instance;
    }

    public static function select(string $sql, array $datas = [], bool $single = true): array
    {
        $pdo = self::getInstance();

        $statement = $pdo->prepare($sql);

        $statement->execute($datas);

        $result = $single ? $statement->fetch() : $statement->fetchAll();

        return $result;
    }

    public static function modify(string $sql, array $datas = []): int
    {
        $pdo = self::getInstance();

        $statement = $pdo->prepare($sql);
        $statement->execute($datas);

        if (str_starts_with(strtoupper(trim($sql)), 'INSERT')) {
            return (int) $pdo->lastInsertId();
        }

        return $statement->rowCount();
    }
}
