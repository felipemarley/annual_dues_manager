<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associados - Devs do RN</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Gerenciamento de Associados</h1>

    <!-- Formulário para adicionar novo associado -->
    <section>
        <h2>Adicionar Associado</h2>
        <form action="scripts/add_associado.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>

            <label for="data_filiacao">Data de Filiação:</label>
            <input type="date" id="data_filiacao" name="data_filiacao" required>

            <button type="submit">Cadastrar Associado</button>
        </form>
    </section>

    <!-- Lista de associados -->
    <section>
        <h2>Lista de Associados</h2>
        <div id="associadosList">
            <!-- Aqui faremos uma chamada PHP para listar associados -->
            <?php include 'php/lista_associados.php'; ?>
        </div>
    </section>
</body>
</html>
