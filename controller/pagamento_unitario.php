<?php
require_once '../model/Database.php';

// Verifica se o ID da anuidade foi passado pelo formulário
if (isset($_POST['anuidade_id'])) {
    try {
        $db = Database::getConnection();

        // Obtém o ID da anuidade a ser paga
        $anuidade_id = $_POST['anuidade_id'];

        // Atualiza o status da anuidade para 'pago'
        $stmt = $db->prepare("UPDATE anuidades SET pago = true WHERE id = :anuidade_id");
        $stmt->bindParam(':anuidade_id', $anuidade_id, PDO::PARAM_INT);

        // Executa a atualização
        if ($stmt->execute()) {
            echo "<script>alert('Pagamento registrado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao registrar o pagamento. Tente novamente.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Erro: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('Anuidade não especificada.');</script>";
}

// Redireciona de volta para a página de pagamento
echo "<script>window.location.href = 'pagamento.php';</script>";
?>
