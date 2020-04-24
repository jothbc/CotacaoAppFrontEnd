<?php
    require_once '../app_cotacao/Connection.php';
    require_once '../app_cotacao/Model/Model.php';
    require_once '../app_cotacao/Model/Cliente.php';
    require_once '../app_cotacao/Model/Fornecedor.php';
    require_once '../app_cotacao/Model/Produto.php';

    if(!isset($_GET['route'])){
        die;
    }
    
    $route = $_GET['route'];

    if($route == 'cadastro'){
        require_once '../app_cotacao/index/cadastro.php';
    }
    if($route == 'login'){
        require_once '../app_cotacao/index/login.php';
    }
    if($route == 'logoff'){
        session_start();
        session_destroy();
        header("Location: index.html");
    }

    // // Controle das rotas abaixo, todas as rotas a baixo tem que estar logado para realizar
    // if(!isset($_SESSION['id']) || !isset($_SESSION['company_name'])){
    //     die;
    // }

    if($route == 'removerItemPedido'){
        require_once '../app_cotacao/cliente/removerItemPedido.php';
    }
    if($route == 'buscarProduto'){
        require_once '../app_cotacao/cliente/buscarProduto.php';
    }
    if($route == 'adicionarItemPedido'){
        require_once '../app_cotacao/cliente/adicionarItemPedido.php';
    }
    if($route == 'removerPedido'){
        require_once '../app_cotacao/cliente/removerPedido.php';
    }
    if($route == 'novoPedido'){
        require_once '../app_cotacao/cliente/novoPedido.php';
    }
    if($route == 'adicionarCliente'){
        require_once '../app_cotacao/fornecedor/adicionarCliente.php';
    }
    if($route == 'removerCliente'){
        require_once '../app_cotacao/fornecedor/removerCliente.php';
    }
    if($route == 'buscarCotacoesCliente'){
        require_once '../app_cotacao/fornecedor/buscarCotacoesCliente.php';
    }


?>