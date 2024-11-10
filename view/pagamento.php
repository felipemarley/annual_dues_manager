<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Pagamento</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Registro de Pagamento de Anuidades</h1>

    <!-- Formulário de Seleção do Associado -->
    <h3>Escolher Associado</h3>
    <form action="pagamento.php" method="GET">
        <label for="associado">Associado:</label>
        <select name="associado_id" id="associado" required>
            <option value="" disabled selected>Selecione um Associado</option>
            <?php
            require_once '../model/Database.php';
            $db = Database::getConnection();

            // Exibe os associados disponíveis
            $query = $db->query("SELECT id, nome FROM associados");
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                // Garantir que a seleção seja sempre resetada
                echo "<option value='{$row['id']}' " . (isset($_GET['associado_id']) && $_GET['associado_id'] == $row['id'] ? 'selected' : '') . ">{$row['nome']}</option>";
            }
            ?>
        </select>
        <button type="submit">Verificar Anuidades</button>
    </form>

    <div id="pagamentoList">
        <?php
        // Verifica se o associado foi selecionado
        if (isset($_GET['associado_id'])) {
            $associado_id = $_GET['associado_id'];

            // Consulta os dados do associado
            $stmt = $db->prepare("SELECT nome FROM associados WHERE id = :associado_id");
            $stmt->bindParam(':associado_id', $associado_id);
            $stmt->execute();
            $associado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($associado) {
                echo "<h3>Associado: {$associado['nome']}</h3>";

                // Consulta as anuidades devidas (não pagas) pelo associado
                $stmt = $db->prepare("
                    SELECT an.id, an.ano, an.valor, an.pago
                    FROM anuidades an
                    WHERE an.associado_id = :associado_id AND an.pago = false
                ");
                $stmt->bindParam(':associado_id', $associado_id);
                $stmt->execute();

                $anuidades_pendentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Exibe as anuidades pendentes
                if ($anuidades_pendentes) {
                    echo "<h3>Anuidades Pendentes:</h3><table border='1'><thead><tr><th>Ano</th><th>Valor</th><th>Status</th><th>Ação</th></tr></thead><tbody>";
                    foreach ($anuidades_pendentes as $anuidade) {
                        echo "<tr>";
                        echo "<td>{$anuidade['ano']}</td>";
                        echo "<td>R$ {$anuidade['valor']}</td>";
                        echo "<td>" . ($anuidade['pago'] ? 'Pago' : 'Não Pago') . "</td>";
                        echo "<td>
                                <form action='../controller/pagamento_unitario.php' method='POST'>
                                    <input type='hidden' name='anuidade_id' value='{$anuidade['id']}'>
                                    <button type='submit'>Dar Baixa</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";

                    // Formulário para dar baixa total (pagar todas as anuidades)
                    echo "<h3>Pagar Todas as Anuidades</h3>";
                    echo "<form action='../controller/pagamento_total.php' method='POST'>
                            <input type='hidden' name='associado_id' value='{$associado_id}'>
                            <button type='submit'>Pagar Todas as Anuidades</button>
                          </form>";
                } else {
                    echo "<p>Não há anuidades pendentes para este associado.</p>";
                }

                // Consulta as anuidades já pagas (pagas) pelo associado
                $stmt = $db->prepare("
                    SELECT an.id, an.ano, an.valor, an.pago
                    FROM anuidades an
                    WHERE an.associado_id = :associado_id AND an.pago = true
                ");
                $stmt->bindParam(':associado_id', $associado_id);
                $stmt->execute();

                $anuidades_pagas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Exibe as anuidades pagas
                if ($anuidades_pagas) {
                    echo "<h3>Anuidades Pagas:</h3><table border='1'><thead><tr><th>Ano</th><th>Valor</th><th>Status</th></tr></thead><tbody>";
                    foreach ($anuidades_pagas as $anuidade) {
                        echo "<tr>";
                        echo "<td>{$anuidade['ano']}</td>";
                        echo "<td>R$ {$anuidade['valor']}</td>";
                        echo "<td>" . ($anuidade['pago'] ? 'Pago' : 'Não Pago') . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p>Não há anuidades pagas para este associado.</p>";
                }

            } else {
                echo "<p>Associado não encontrado.</p>";
            }
        } else {
            echo "<p>Selecione um associado para visualizar as anuidades devidas.</p>";
        }
        ?>
    </div>
</body>
</html>
