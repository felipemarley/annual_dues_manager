<?php
require_once '../model/Database.php';

try {
    $db = Database::getConnection();

    // Dados do formulário
    $associado_id = $_POST['associado_id'];
    $ano = $_POST['ano'];
    $valor = $_POST['valor'];

    // Inserção da anuidade associada ao associado
    $stmt = $db->prepare("INSERT INTO anuidades (associado_id, ano, valor, pago) VALUES (:associado_id, :ano, :valor, false)");
    $stmt->bindParam(':associado_id', $associado_id);
    $stmt->bindParam(':ano', $ano);
    $stmt->bindParam(':valor', $valor);

    // Verificação de execução
    if ($stmt->execute()) {
        echo "Anuidade cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar anuidade.";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
