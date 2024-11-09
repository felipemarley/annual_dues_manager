<?php

require_once '../model/Database.php';

try {
    $db = Database::getConnection();

    $stmt = $db->prepare("SELECT a.nome, an.ano, an.valor, an.pago
                            FROM associados a
                            JOIN anuidades an ON an.associado_id = a.id  -- Aqui estamos associando o associado_id de anuidades ao id de associados
                            LEFT JOIN pagamentos p ON a.id = p.associado_id AND an.ano = p.ano
                            WHERE a.id = :associado_id;");

    $stmt->bindParam(':associado_id', $associado_id, PDO::PARAM_INT);

    // Executa a consulta
    $stmt->execute();

    // Recupera e exibe os resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultados as $linha) {
        echo "Nome: " . $linha['nome'] . ", Ano: " . $linha['ano'] . ", Valor: " . $linha['valor'] . ", Pago: " . ($linha['pago'] ? 'Sim' : 'Não') . "<br>";
    }
} catch (PDOException $e) {
    echo "Erro ao calcular cobranças: " . $e->getMessage();
}
