<?php
require_once '../model/Database.php';

if (isset($_POST['associado_id'])) {
    $associado_id = $_POST['associado_id'];

    try {
        $db = Database::getConnection();
        
        // Consulta para buscar as anuidades de um associado específico
        $stmt = $db->prepare("SELECT ano, valor, pago FROM anuidades WHERE associado_id = :associado_id");
        $stmt->bindParam(':associado_id', $associado_id, PDO::PARAM_INT);
        $stmt->execute();

        // Exibe o nome do associado
        $assocQuery = $db->prepare("SELECT nome FROM associados WHERE id = :associado_id");
        $assocQuery->bindParam(':associado_id', $associado_id, PDO::PARAM_INT);
        $assocQuery->execute();
        $assoc = $assocQuery->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Anuidades de {$assoc['nome']}</h3>";
        
        // Exibe os resultados em uma tabela
        echo "<table border='1'>";
        echo "<tr><th>Ano</th><th>Valor</th><th>Pago</th></tr>";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pago = $row['pago'] ? 'Sim' : 'Não';
            echo "<tr><td>{$row['ano']}</td><td>R$ {$row['valor']}</td><td>{$pago}</td></tr>";
        }
        echo "</table>";
        
    } catch (PDOException $e) {
        echo "Erro ao listar anuidades: " . $e->getMessage();
    }
} else {
    echo "Selecione um associado para exibir as anuidades.";
}
?>
