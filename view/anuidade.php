<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Anuidade</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Cadastrar Anuidade</h2>
    <form action="../controller/add_anuidade.php" method="POST">
        <label for="associado">Associado:</label>
        <select name="associado_id" id="associado" required>
            <?php
            // Inclui a conexão com o banco
            require_once '../model/Database.php';
            $db = Database::getConnection();

            // Consulta os associados cadastrados
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
</body>
</html>
