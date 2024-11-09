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

        if ($result > 0) {
            // Caso exista uma anuidade para esse associado e ano, exibe a mensagem
            echo "<script>alert('Já existe uma anuidade registrada para o ano {$ano}. Por favor, atualize a anuidade existente.');</script>";
        } else {
            // Inserção da nova anuidade
            $stmt = $db->prepare("INSERT INTO anuidades (associado_id, ano, valor, pago) VALUES (:associado_id, :ano, :valor, false)");
            $stmt->bindParam(':associado_id', $associado_id);
            $stmt->bindParam(':ano', $ano);
            $stmt->bindParam(':valor', $valor);

            // Verifica se a inserção foi bem-sucedida
            if ($stmt->execute()) {
                echo "<script>alert('Anuidade cadastrada com sucesso!');</script>";
            } else {
                echo "<script>alert('Erro ao cadastrar anuidade.');</script>";
            }
        }

    } catch (PDOException $e) {
        echo "<script>alert('Erro: " . $e->getMessage() . "');</script>";
    }
}
?>
