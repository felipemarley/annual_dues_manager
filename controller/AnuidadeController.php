<?php
// controller/AnuidadeController.php

require_once 'model/Anuidade.php';

class AnuidadeController {
    public function listar() {
        $anuidade = new Anuidade();
        $anuidades = $anuidade->listarTodas();
        require 'view/anuidade/list.php';
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ano = $_POST['ano'];
            $valor = $_POST['valor'];
            
            $anuidade = new Anuidade();
            $anuidade->cadastrar($ano, $valor);
            header('Location: index.php?controller=Anuidade&action=listar');
            exit;
        }
        require 'view/anuidade/form.php';
    }

    public function atualizar($id) {
        $anuidade = new Anuidade();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $valor = $_POST['valor'];
            $anuidade->atualizarValor($id, $valor);
            header('Location: index.php?controller=Anuidade&action=listar');
            exit;
        }
        $anuidadeInfo = $anuidade->buscarPorId($id);
        require 'view/anuidade/form.php';
    }

    public function excluir($id) {
        $anuidade = new Anuidade();
        $anuidade->excluir($id);
        header('Location: index.php?controller=Anuidade&action=listar');
        exit;
    }
}
