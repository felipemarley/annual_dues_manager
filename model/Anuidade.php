<?php
// model/Anuidade.php

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

    // Método para listar todas as anuidades
    public function listarTodas() {
        $sql = "SELECT * FROM anuidades ORDER BY ano DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para buscar uma anuidade por ID
    public function buscarPorId($id) {
        $sql = "SELECT * FROM anuidades WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para atualizar o valor de uma anuidade específica
    public function atualizarValor($id, $valor) {
        $sql = "UPDATE anuidades SET valor = :valor WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Método para excluir uma anuidade
    public function excluir($id) {
        $sql = "DELETE FROM anuidades WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
