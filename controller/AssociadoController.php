<?php
require_once '../model/Associado.php';

$associado = new Associado();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $dataFiliacao = $_POST['data_filiacao'];
    
    $associado->cadastrarAssociado($nome, $email, $cpf, $dataFiliacao);
    header('Location: ../view/associado/list.php');
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $associados = $associado->listarAssociados();
    include '../view/associado/list.php';
}

?>