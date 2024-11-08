<?php
require_once '../model/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $associado_id = $_POST['associado_id'];
    $ano = $_POST['ano'];

    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO pagamentos (associado_id, ano, pago) VALUES (:associado_id, :ano, TRUE)");
        $stmt->bindParam(':associado_id', $associado_id);
        $stmt->bindParam(':ano', $ano);
        $stmt->execute();
        echo "Pagamento registrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao registrar pagamento: " . $e->getMessage();
    }
}
?>
