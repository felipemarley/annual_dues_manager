<?php

require_once 'model/Pagamento.php';

class PagamentoController {
    public function listar() {
        $pagamento = new Pagamento();
        $pagamentos = $pagamento->listarTodos();
        require 'view/pagamento/list.php';
    }

    public function registrarPagamento($associadoId, $anuidadeId) {
        $pagamento = new Pagamento();
        $pagamento->marcarComoPago($associadoId, $anuidadeId);
        header('Location: index.php?controller=Pagamento&action=listar');
        exit;
    }

    public function listarDevedores() {
        $pagamento = new Pagamento();
        $devedores = $pagamento->listarDevedores();
        require 'view/pagamento/devedores.php';
    }

    public function listarEmDia() {
        $pagamento = new Pagamento();
        $emDia = $pagamento->listarEmDia();
        require 'view/pagamento/emdia.php';
    }
}
