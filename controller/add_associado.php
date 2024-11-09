<?php
require_once '../model/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $data_filiacao = $_POST['data_filiacao'];

    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO associados (nome, email, cpf, data_filiacao) VALUES (:nome, :email, :cpf, :data_filiacao)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':data_filiacao', $data_filiacao);
        $stmt->execute();

        // Exibe uma mensagem de sucesso e redireciona
        echo "<script>alert('Associado cadastrado com sucesso!'); window.location.href='../associados.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Erro ao cadastrar associado: " . $e->getMessage() . "'); window.location.href='../associados.php';</script>";
    }
}
?>
