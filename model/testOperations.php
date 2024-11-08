<?php
require_once 'Database.php';

$db = Database::getConnection();

function testBulkInsert($db) {
    $associados = [
        ['nome' => 'Ana Souza', 'email' => 'ana.souza@example.com', 'cpf' => '11122233344', 'data_filiacao' => '2023-01-10'],
        ['nome' => 'Carlos Lima', 'email' => 'carlos.lima@example.com', 'cpf' => '22233344455', 'data_filiacao' => '2022-06-15'],
        ['nome' => 'Fernanda Alves', 'email' => 'fernanda.alves@example.com', 'cpf' => '33344455566', 'data_filiacao' => '2024-02-20'],
        // Inserção com CPF duplicado para testar restrição
        ['nome' => 'Paulo Santos', 'email' => 'paulo.santos@example.com', 'cpf' => '11122233344', 'data_filiacao' => '2023-07-18'],
        ['nome' => 'Maria Oliveira', 'email' => 'maria.oliveira@example.com', 'cpf' => '44455566677', 'data_filiacao' => '2021-11-12'],
    ];

    foreach ($associados as $associado) {
        try {
            $sql = "INSERT INTO associados (nome, email, cpf, data_filiacao) VALUES (:nome, :email, :cpf, :data_filiacao)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':nome' => $associado['nome'],
                ':email' => $associado['email'],
                ':cpf' => $associado['cpf'],
                ':data_filiacao' => $associado['data_filiacao']
            ]);
            echo "Associado {$associado['nome']} inserido com sucesso!<br>";
        } catch (PDOException $e) {
            echo "Erro ao inserir associado {$associado['nome']}: " . $e->getMessage() . "<br>";
        }
    }
}

testBulkInsert($db);
?>
