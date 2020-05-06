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
        die;
    }
    if($route == 'login'){
        require_once '../app_cotacao/index/login.php';
        die;
    }
    if($route == 'logoff'){
        session_start();
        session_destroy();
        header("Location: index.html");
        die;
    }

    // // Controle das rotas abaixo, todas as rotas a baixo tem que estar logado para realizar
    // if(!isset($_SESSION['id']) || !isset($_SESSION['company_name'])){
    //     session_destroy();
    //     header("Location: index.html");
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
    if($route == 'inverterStatus'){
        require_once '../app_cotacao/cliente/inverterStatus.php';
    }
    if($route == 'aprovarDesaprovar'){
        require_once '../app_cotacao/cliente/aprovarDesaprovar.php';
    }
    if($route == 'incluirObs'){
        require_once '../app_cotacao/cliente/incluirObs.php';
    }
    if($route == 'getObs'){
        require_once '../app_cotacao/cliente/getObs.php';
    }
    if($route == 'addPretencao'){
        require_once '../app_cotacao/cliente/addPretencao.php';
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
    if($route == 'enviarPrecos'){
        require_once '../app_cotacao/fornecedor/enviarPrecos.php';
    }
    if($route == 'procurarCliente'){
        require_once '../app_cotacao/fornecedor/procurarCliente.php';
    }
    

?>