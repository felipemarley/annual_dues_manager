<?php
require_once '../model/Database.php';

// Verifica se o ID do associado foi passado
if (isset($_POST['associado_id'])) {
    try {
        $db = Database::getConnection();

        // Obtém o ID do associado
        $associado_id = $_POST['associado_id'];

        // Atualiza o status de todas as anuidades do associado para 'pago'
        $stmt = $db->prepare("UPDATE anuidades SET pago = true WHERE associado_id = :associado_id AND pago = false");
        $stmt->bindParam(':associado_id', $associado_id, PDO::PARAM_INT);

        // Executa a atualização
        if ($stmt->execute()) {
            echo "<script>alert('Todas as anuidades foram pagas com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao registrar o pagamento total. Tente novamente.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Erro: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('Associado não especificado.');</script>";
}

// Redireciona de volta para a página de pagamento
echo "<script>window.location.href = 'pagamento.php';</script>";
?>
