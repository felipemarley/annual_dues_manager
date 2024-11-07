<?php

require_once 'Database.php';

class Pagamento {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function marcarComoPago($associadoId, $anuidadeId) {
        $sql = "INSERT INTO pagamentos (associado_id, anuidade_id, pago) VALUES (:associadoId, :anuidadeId, true)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':associadoId', $associadoId, PDO::PARAM_INT);
        $stmt->bindParam(':anuidadeId', $anuidadeId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function listarTodos() {
        $sql = "SELECT p.id, a.nome, an.ano, p.pago 
                FROM pagamentos p
                JOIN associados a ON p.associado_id = a.id
                JOIN anuidades an ON p.anuidade_id = an.id
                ORDER BY a.nome, an.ano";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarEmDia() {
        $sql = "SELECT a.nome, a.email
                FROM associados a
                WHERE NOT EXISTS (
                    SELECT 1 
                    FROM anuidades an
                    LEFT JOIN pagamentos p ON p.anuidade_id = an.id AND p.associado_id = a.id AND p.pago = true
                    WHERE p.id IS NULL AND an.ano <= EXTRACT(YEAR FROM CURRENT_DATE)
                )";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function listarDevedores() {
        $sql = "SELECT a.nome, a.email, an.ano
                FROM associados a
                JOIN anuidades an ON an.ano <= EXTRACT(YEAR FROM CURRENT_DATE)
                LEFT JOIN pagamentos p ON p.associado_id = a.id AND p.anuidade_id = an.id AND p.pago = true
                WHERE p.id IS NULL
                ORDER BY a.nome, an.ano";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
