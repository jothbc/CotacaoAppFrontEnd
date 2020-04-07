<?php
    session_start();
    require '../../../app_cotacao/Conexao/JDBC.php';
    require '../../../app_cotacao/Cliente/CotacaoClienteInfo.model.php';
    require '../../../app_cotacao/Cliente/CotacaoClienteInfo.Service.php';
    require '../../../app_cotacao/Cliente/Cliente.model.php';
    require '../../../app_cotacao/Cliente/ClienteService.php';
    require '../../../app_cotacao/Cliente/nova_cotacao.php';
?>