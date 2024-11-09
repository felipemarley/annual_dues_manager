<!-- controller/atualizar_valor_anuidade.php -->
<?php
require_once '../model/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = Database::getConnection();
        $ano = $_POST['ano'];
        $valor = $_POST['valor'];

        // Verifica se já existe uma anuidade para o ano
        $stmt = $db->prepare("SELECT * FROM anuidades WHERE ano = :ano");
        $stmt->bindParam(':ano', $ano);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Atualiza o valor existente
            $stmt = $db->prepare("UPDATE anuidades SET valor = :valor WHERE ano = :ano");
        } else {
            // Insere um novo ano e valor
            $stmt = $db->prepare("INSERT INTO anuidades (ano, valor) VALUES (:ano, :valor)");
        }

        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':valor', $valor);

        if ($stmt->execute()) {
            echo "Valor atualizado com sucesso!";
        } else {
            echo "Erro ao atualizar valor.";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>
