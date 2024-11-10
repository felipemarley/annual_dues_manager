<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Anuidade</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
        // Função para alternar entre as seções de conteúdo
        function showSection(sectionId) {
            // Esconde todas as seções
            document.getElementById('calcularAnuidade').style.display = 'none';
            document.getElementById('listarAnuidade').style.display = 'none';
            document.getElementById('atualizarAnuidade').style.display = 'none';

            // Mostra apenas a seção escolhida
            document.getElementById(sectionId).style.display = 'block';

            // Reinicia a seleção de associado ao trocar de seção
            let selects = document.querySelectorAll("select[name='associado_id']");
            selects.forEach(select => select.selectedIndex = 0);
        }
    </script>
</head>
<body>
    <h1>Gerenciamento de Anuidades</h1>
    <nav>
        <button onclick="showSection('calcularAnuidade')">Calcular Anuidades</button>
        <button onclick="showSection('listarAnuidade')">Listar Anuidades</button>
        <button onclick="showSection('atualizarAnuidade')">Ajustar Anuidade</button>
    </nav>

    <section>
        <!-- Seção para Calcular Anuidades -->
        <div id="calcularAnuidade" style="display: none;">
            <h3>Calcular Anuidades</h3>
            <form action="../controller/calcular_anuidade.php" method="POST">
                <label for="associado">Associado:</label>
                <select name="associado_id" id="associado" required>
                    <option value="" disabled selected>Selecione um Associado</option>
                    <?php
                    require_once '../model/Database.php';
                    $db = Database::getConnection();
                    $query = $db->query("SELECT id, nome FROM associados");
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                    }
                    ?>
                </select>
                <button type="submit">Calcular Anuidades</button>
            </form>
        </div>

        <!-- Seção para Listar Anuidades -->
        <div id="listarAnuidade" style="display: none;">
            <h3>Listar Anuidades</h3>
            <form method="POST" action="">
                <label for="associado_id">Selecionar Associado:</label>
                <select name="associado_id" id="associado_id" required>
                    <option value="" disabled selected>Selecione um Associado</option>
                    <?php
                    $db = Database::getConnection();
                    $query = $db->query("SELECT id, nome FROM associados");
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                    }
                    ?>
                </select>
                <button type="submit">Exibir Anuidades</button>
            </form>

            <?php
            if (isset($_POST['associado_id'])) {
                $associado_id = $_POST['associado_id'];
                try {
                    $db = Database::getConnection();
                    $stmt = $db->prepare("SELECT ano, valor, pago FROM anuidades WHERE associado_id = :associado_id");
                    $stmt->bindParam(':associado_id', $associado_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $assocQuery = $db->prepare("SELECT nome FROM associados WHERE id = :associado_id");
                    $assocQuery->bindParam(':associado_id', $associado_id, PDO::PARAM_INT);
                    $assocQuery->execute();
                    $assoc = $assocQuery->fetch(PDO::FETCH_ASSOC);

                    echo "<h3>Anuidades de {$assoc['nome']}</h3>";
                    echo "<table border='1'>";
                    echo "<tr><th>Ano</th><th>Valor</th><th>Pago</th></tr>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $pago = $row['pago'] ? 'Sim' : 'Não';
                        echo "<tr><td>{$row['ano']}</td><td>R$ {$row['valor']}</td><td>{$pago}</td></tr>";
                    }
                    echo "</table>";
                } catch (PDOException $e) {
                    echo "Erro ao listar anuidades: " . $e->getMessage();
                }
            }
            ?>
        </div>

        <!-- Seção para Ajustar Anuidade -->
        <div id="atualizarAnuidade" style="display: none;">
            <h3>Ajustar Anuidade</h3>
            <form action="../controller/atualizar_anuidade.php" method="POST">
                <label for="associado">Selecionar Associado:</label>
                <select name="associado_id" id="associado" required>
                    <option value="" disabled selected>Selecione um Associado</option>
                    <?php
                    $db = Database::getConnection();
                    $query = $db->query("SELECT id, nome FROM associados");
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                    }
                    ?>
                </select>

                <label for="ano">Ano da Anuidade a Ajustar:</label>
                <input type="number" name="ano" id="ano" required min="1900" max="2100">

                <label for="valor">Novo Valor (R$):</label>
                <input type="number" name="valor" id="valor" required step="0.01">

                <button type="submit">Ajustar Anuidade</button>
            </form>
        </div>
    </section>

    <script>
        showSection('listarAnuidade');
    </script>
</body>
</html>
