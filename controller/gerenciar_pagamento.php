<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Checkout de Anuidades</title>
    <link rel="stylesheet" href="../view/css/style.css">
</head>
<body>
    <h2>Checkout de Anuidades Devidas</h2>
    <form action="checkout_anuidade.php" method="GET">
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
        <button type="submit">Verificar Anuidades</button>
    </form>

    <?php
    if (isset($_GET['associado_id'])) {
        $associado_id = $_GET['associado_id'];

        // Consulta as anuidades devidas pelo associado
        $stmt = $db->prepare("
            SELECT an.ano, an.valor, an.pago 
            FROM anuidades an
            JOIN associados a ON a.id = :associado_id
            WHERE CAST(an.ano AS INTEGER) >= EXTRACT(YEAR FROM a.data_filiacao)
        ");
        $stmt->bindParam(':associado_id', $associado_id);
        $stmt->execute();

        $anuidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total_devido = 0;

        echo "<h3>Anuidades devidas:</h3><ul>";
        foreach ($anuidades as $anuidade) {
            echo "<li>Ano: {$anuidade['ano']} - Valor: R$ {$anuidade['valor']} - Pago: " . ($anuidade['pago'] ? 'Sim' : 'Não') . "</li>";
            if (!$anuidade['pago']) {
                $total_devido += $anuidade['valor'];
            }
        }
        echo "</ul>";
        echo "<p><strong>Total Devido:</strong> R$ $total_devido</p>";
    }
    ?>
</body>
</html>
