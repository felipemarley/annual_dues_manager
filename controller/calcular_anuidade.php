<?php
require_once '../model/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = Database::getConnection();

        // Dados do formulário
        $associado_id = $_POST['associado_id'];
        $ano_atual = date('Y');

        // Busca a data de filiação do associado
        $stmt = $db->prepare("SELECT data_filiacao FROM associados WHERE id = :associado_id");
        $stmt->bindParam(':associado_id', $associado_id, PDO::PARAM_INT);
        $stmt->execute();
        $associado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($associado) {
            $ano_filiacao = (int)date('Y', strtotime($associado['data_filiacao']));
            
            // Loop para cada ano desde a filiação até o ano atual
            for ($ano = $ano_filiacao; $ano <= $ano_atual; $ano++) {
                // Verifica se já existe uma anuidade para o associado e o ano atual
                $stmt = $db->prepare("SELECT COUNT(*) FROM anuidades WHERE associado_id = :associado_id AND ano = :ano");
                $stmt->bindParam(':associado_id', $associado_id, PDO::PARAM_INT);
                $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchColumn();

                if ($result == 0) {
                    // Insere a anuidade para o ano caso ainda não exista
                    $valor = calcularValorAnuidade($ano); // Função para calcular o valor baseado no ano
                    $stmt = $db->prepare("INSERT INTO anuidades (associado_id, ano, valor, pago) VALUES (:associado_id, :ano, :valor, false)");
                    $stmt->bindParam(':associado_id', $associado_id);
                    $stmt->bindParam(':ano', $ano);
                    $stmt->bindParam(':valor', $valor);
                    $stmt->execute();
                }
            }

            echo "<script>alert('Anuidades geradas automaticamente até o ano atual!');</script>";
        } else {
            echo "<script>alert('Associado não encontrado.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Erro: " . $e->getMessage() . "');</script>";
    }
}

// Função para calcular o valor da anuidade com base no ano
function calcularValorAnuidade($ano) {
    switch ($ano) {
        case 2022:
            return 140.00;
        case 2023:
            return 120.00;
        case 2024:
            return 100.00;
        default:
            return 150.00; // Valor padrão para anos futuros e passados
    }
}
?>
