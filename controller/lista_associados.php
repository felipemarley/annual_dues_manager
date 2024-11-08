<?php
require_once '../model/Database.php';

try {
    $db = Database::getConnection();
    $query = "SELECT * FROM associados";
    $result = $db->query($query);

    echo "<table border='1'>";
    echo "<tr><th>Nome</th><th>Email</th><th>CPF</th><th>Data de Filiação</th></tr>";
    foreach ($result as $row) {
        echo "<tr><td>{$row['nome']}</td><td>{$row['email']}</td><td>{$row['cpf']}</td><td>{$row['data_filiacao']}</td></tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Erro ao listar associados: " . $e->getMessage();
}
?>
