<?php

require_once 'Database.php';

class Associado {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function cadastrarAssociado($nome, $email, $cpf, $dataFiliacao) {
        $sql = "INSERT INTO associados (nome, email, cpf, data_filiacao) VALUES (:nome, :email, :cpf, :dataFiliacao)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':dataFiliacao', $dataFiliacao);
        return $stmt->execute();
    }

    public function listarAssociados() {
        $sql = "SELECT * FROM associados";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>