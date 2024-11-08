<?php
require_once '../model/Database.php';

try {
    $db = Database::getConnection();
    $query = "SELECT * FROM anuidades";
    $result = $db->query($query);

    echo "<table border='1'>";
    echo "<tr><th>Ano</th><th>Valor</th></tr>";
    foreach ($result as $row) {
        echo "<tr><td>{$row['ano']}</td><td>{$row['valor']}</td></tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Erro ao listar anuidades: " . $e->getMessage();
}
?>
