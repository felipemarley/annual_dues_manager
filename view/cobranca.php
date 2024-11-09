<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Cobranças</title>
</head>
<body>
    <h2>Consulta de Cobranças</h2>
    <form action="cobranca.php" method="post">
        <label for="nome_associado">Nome do Associado:</label>
        <input type="text" name="nome_associado" id="nome_associado" required>
        <button type="submit">Consultar</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once '../model/Database.php';

        try {
            $db = Database::getConnection();

            $nome_associado = $_POST['nome_associado'];


            $stmt = $db->prepare("SELECT a.nome, an.ano, an.valor, an.pago
                                    FROM associados a
                                    JOIN anuidades an ON an.associado_id = a.id  -- Associa o associado_id de anuidades ao id de associados
                                LEFT JOIN pagamentos p ON a.id = p.associado_id AND an.ano = p.ano
                                  WHERE a.nome = :nome_associado");  
            $stmt->bindParam(':nome_associado', $nome_associado, PDO::PARAM_STR);
            $stmt->execute();

            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($resultados) {
                echo "<h3>Resultados para o Associado: {$nome_associado}</h3>";
                echo "<table border='1'>
                        <tr>
                            <th>Nome</th>
                            <th>Ano</th>
                            <th>Valor</th>
                            <th>Pago</th>
                        </tr>";
                foreach ($resultados as $linha) {
                    echo "<tr>
                            <td>{$linha['nome']}</td>
                            <td>{$linha['ano']}</td>
                            <td>{$linha['valor']}</td>
                            <td>" . ($linha['pago'] ? 'Sim' : 'Não') . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Nenhuma cobrança encontrada para o associado: {$nome_associado}</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Erro ao calcular cobranças: " . $e->getMessage() . "</p>";
        }
    }
    ?>
</body>
</html>
