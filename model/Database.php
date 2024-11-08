<?php
class Database {
    private static $connection;

    public static function getConnection() {
        if (!self::$connection) {
            try {
                $host = 'localhost';
                $port = '5432';
                $dbname = 'devs_do_rn';
                $username = 'postgres';
                $password = '1234';

                // Conecte-se ao banco principal para verificação e criação do banco
                self::$connection = new PDO("pgsql:host=$host;port=$port;dbname=postgres", $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Verifica se o banco de dados já existe, caso contrário, cria-o
                self::createDatabaseIfNotExists($dbname);

                // Conecte-se ao banco de dados específico
                self::$connection = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                echo "Conexão bem-sucedida!";
            } catch (PDOException $e) {
                echo "Erro de conexão: " . $e->getMessage();
            }
        }
        return self::$connection;
    }

    private static function createDatabaseIfNotExists($dbname) {
        // Verifique se o banco de dados já existe
        $checkDB = self::$connection->query("SELECT 1 FROM pg_database WHERE datname = '$dbname'");
        if (!$checkDB->fetch()) {
            // Cria o banco de dados se não existir
            self::$connection->exec("CREATE DATABASE $dbname");
            echo "Banco de dados '$dbname' criado com sucesso!";

            // Após criar o banco de dados, carregue o arquivo SQL
            self::runSQLFile('../meu_database.sql');
        }
    }

    private static function runSQLFile($filePath) {
        // Verifica se o arquivo SQL existe
        if (file_exists($filePath)) {
            $sql = file_get_contents($filePath);
            self::$connection->exec($sql);
            echo "Script SQL executado com sucesso!";
        } else {
            echo "Arquivo $filePath não encontrado!";
        }
    }
}
?>
