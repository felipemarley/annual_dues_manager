<?php
class Database {
    private static $connection;

    public static function getConnection() {
        if (!self::$connection) {
            try {
                $host = 'localhost';
                $port = '5432';
                $dbname = 'meu_database';
                $username = 'postgres';
                $password = '1234';

                self::$connection = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Conexão bem-sucedida!";
            } catch (PDOException $e) {
                echo "Erro de conexão: " . $e->getMessage();
            }
        }
        return self::$connection;
    }
}
?>
