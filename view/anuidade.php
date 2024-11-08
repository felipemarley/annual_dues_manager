<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anuidades - Devs do RN</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Gerenciamento de Anuidades</h1>

    <!-- Formulário para adicionar nova anuidade -->
    <section>
        <h2>Adicionar Anuidade</h2>
        <form action="scripts/add_anuidade.php" method="post">
            <label for="ano">Ano:</label>
            <input type="number" id="ano" name="ano" required>

            <label for="valor">Valor (R$):</label>
            <input type="text" id="valor" name="valor" required>

            <button type="submit">Cadastrar Anuidade</button>
        </form>
    </section>

    <!-- Lista de anuidades existentes -->
    <section>
        <h2>Anuidades Existentes</h2>
        <div id="anuidadesList">
            <?php include 'php/lista_anuidades.php'; ?>
        </div>
    </section>
</body>
</html>
