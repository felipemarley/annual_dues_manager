<?php
require_once '../model/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = Database::getConnection();

        // Dados do formulário
        $associado_id = $_POST['associado_id'];
        $ano = $_POST['ano'];
        $valor = $_POST['valor'];

        // Verifica se já existe uma anuidade para o associado e o ano informado
        $stmt = $db->prepare("SELECT COUNT(*) FROM anuidades WHERE associado_id = :associado_id AND ano = :ano");
        $stmt->bindParam(':associado_id', $associado_id, PDO::PARAM_INT);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchColumn();

        if ($result == 0) {
            // Caso não exista uma anuidade para esse associado e ano, exibe a mensagem
            echo "<script>alert('Não há anuidade registrada para o ano {$ano}. Por favor, adicione a anuidade para este ano antes de tentar atualizá-la.');</script>";
        } else {
            // Atualiza a anuidade se o ano já existir
            $stmt = $db->prepare("UPDATE anuidades SET valor = :valor WHERE associado_id = :associado_id AND ano = :ano");
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':associado_id', $associado_id);
            $stmt->bindParam(':ano', $ano);

            // Verifica se a atualização foi bem-sucedida
            if ($stmt->execute()) {
                echo "<script>alert('Anuidade atualizada com sucesso!');</script>";
            } else {
                echo "<script>alert('Erro ao atualizar anuidade.');</script>";
            }
        }

    } catch (PDOException $e) {
        echo "<script>alert('Erro: " . $e->getMessage() . "');</script>";
    }
}
?>
