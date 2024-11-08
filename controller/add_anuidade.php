<?php
require_once '../../model/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ano = $_POST['ano'];
    $valor = $_POST['valor'];

    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO anuidades (ano, valor) VALUES (:ano, :valor) ON CONFLICT (ano) DO UPDATE SET valor = :valor");
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':valor', $valor);
        $stmt->execute();
        echo "Anuidade cadastrada/atualizada com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar/atualizar anuidade: " . $e->getMessage();
    }
}
?>
