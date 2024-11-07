<?php

class Database {
    private static $connection = null;

    // Parâmetros da conexão com o banco de dados
    private const HOST = 'localhost';
    private const DBNAME = 'nome_do_banco';  // Substitua pelo nome do seu banco de dados
    private const USER = 'seu_usuario';      // Substitua pelo seu usuário do banco de dados
    private const PASSWORD = 'sua_senha';    // Substitua pela sua senha do banco de dados

    private function __construct() {
        // Construtor privado para impedir a criação de instâncias fora da classe
    }

    public static function getConnection() {
        // Verifica se já existe uma conexão
        if (self::$connection === null) {
            try {
                $dsn = 'pgsql:host=' . self::HOST . ';dbname=' . self::DBNAME;
                self::$connection = new PDO($dsn, self::USER, self::PASSWORD);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    public static function closeConnection() {
        self::$connection = null;
    }
}
