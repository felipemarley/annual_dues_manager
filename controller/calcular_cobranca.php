<?php
require_once '../model/Database.php';

try {
    $db = Database::getConnection();
    $query = "
        SELECT a.nome, a.data_filiacao, an.ano, an.valor
        FROM associados a
        JOIN anuidades an ON an.ano >= EXTRACT(YEAR FROM a.data_filiacao)
        LEFT JOIN pagamentos p ON a.id = p.associado_id AND an.ano = p.ano
        WHERE p.pago IS NULL OR p.pago = FALSE";
    $result = $db->query($query);

    echo "<table border='1'>";
    echo "<tr><th>Nome</th><th>Data de Filiação</th><th>Ano</th><th>Valor</th></tr>";
    foreach ($result as $row) {
        echo "<tr><td>{$row['nome']}</td><td>{$row['data_filiacao']}</td><td>{$row['ano']}</td><td>{$row['valor']}</td></tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Erro ao calcular cobranças: " . $e->getMessage();
}
?>
