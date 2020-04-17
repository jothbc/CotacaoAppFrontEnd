<?php
    require_once "../../app_cotacao/Cliente/CotacaoClienteInfo.model.php";
    require_once "../../app_cotacao/Cliente/CotacaoClienteInfo.Service.php";
    require_once "../../app_cotacao/Conexao/JDBC.php";
    $cotacao = new CotacaoClienteInfo();
    $cotacao->__set('cliente_id',$_POST['cliente_id']);
    $cotacao->__set('pedido',$_POST['pedido_id']);

    $service = new CotacaoClienteInfoService($cotacao,new Conexao());
    $service->alterStatus();

?>