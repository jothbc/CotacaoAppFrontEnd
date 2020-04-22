<?php
    require_once '../app_cotacao/Connection.php';
    require_once '../app_cotacao/Model/Model.php';
    require_once '../app_cotacao/Model/Cliente.php';
    require_once '../app_cotacao/Model/Fornecedor.php';

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
?>