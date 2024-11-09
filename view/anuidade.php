<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Anuidades - Devs do RN</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
        // Função para alternar entre as seções de conteúdo
        function showSection(sectionId) {
            // Esconde todas as seções
            document.getElementById('addAnuidade').style.display = 'none';
            document.getElementById('listarAnuidade').style.display = 'none';
            document.getElementById('atualizarAnuidade').style.display = 'none';

            // Mostra apenas a seção escolhida
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</head>

<body>
    <h2>Gerenciar Anuidades</h2>
    <nav>
        <ul>
            <li><a href="#" onclick="showSection('addAnuidade'); return false;">Adicionar Anuidade</a></li>
            <li><a href="#" onclick="showSection('listarAnuidade'); return false;">Listar Anuidades</a></li>
            <li><a href="#" onclick="showSection('atualizarAnuidade'); return false;">Ajustar Anuidade</a></li>
        </ul>
    </nav>

    <section>
        <!-- Seção para Adicionar Anuidade -->
        <div id="addAnuidade" style="display: none;">
            <h3>Adicionar Anuidade</h3>
            <!-- Formulário de adição de anuidade -->
            <form action="../controller/add_anuidade.php" method="POST">
                <label for="associado">Associado:</label>
                <select name="associado_id" id="associado" required>
                    <?php
                    require_once '../model/Database.php';
                    $db = Database::getConnection();
                    $query = $db->query("SELECT id, nome FROM associados");
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                    }
                    ?>
                </select>

                <label for="ano">Ano:</label>
                <input type="number" name="ano" id="ano" required min="1900" max="2100">

                <label for="valor">Valor (R$):</label>
                <input type="number" name="valor" id="valor" required step="0.01">

                <button type="submit">Cadastrar Anuidade</button>
            </form>
        </div>

        <!-- Seção para Listar Anuidades -->
        <!-- Seção para Listar Anuidades -->
        <div id="listarAnuidade" style="display: none;">
            <h3>Listar Anuidades</h3>
            <form method="POST" action="../controller/listar_anuidade.php">
                <label for="associado_id">Selecionar Associado:</label>
                <select name="associado_id" id="associado_id" required>
                    <?php
                    // Inclui a conexão com o banco para buscar os associados
                    require_once '../model/Database.php';
                    $db = Database::getConnection();

                    // Consulta para listar os associados
                    $query = $db->query("SELECT id, nome FROM associados");
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                    }
                    ?>
                </select>
                <button type="submit">Exibir Anuidades</button>
            </form>
        </div>

        <!-- Seção para Ajustar Anuidade -->
        <div id="atualizarAnuidade" style="display: none;">
            <h3>Ajustar Anuidade</h3>
            <!-- Formulário para selecionar associado e ajustar anuidades -->
            <form action="../controller/atualizar_anuidade.php" method="POST">
                <label for="associado">Selecionar Associado:</label>
                <select name="associado_id" id="associado" required>
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
        // Exibe a seção "Listar Anuidade" por padrão quando a página é carregada
        showSection('listarAnuidade');
    </script>
</body>

</html>