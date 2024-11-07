<?php

require_once 'Database.php';

class Anuidade {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Método para cadastrar uma nova anuidade
    public function cadastrar($ano, $valor) {
        $sql = "INSERT INTO anuidades (ano, valor) VALUES (:ano, :valor)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->bindParam(':valor', $valor);
        return $stmt->execute();
    }

    public function listarTodas() {
        $sql = "SELECT * FROM anuidades ORDER BY ano DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM anuidades WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarValor($id, $valor) {
        $sql = "UPDATE anuidades SET valor = :valor WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function excluir($id) {
        $sql = "DELETE FROM anuidades WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
