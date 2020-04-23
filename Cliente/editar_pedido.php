<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['company_name'])) {
    header("Location: ../route.php?route=logoff");
}
if(!isset($_GET['pedido'])){
    header("Location: index.php");
}
include_once '../../app_cotacao/Connection.php';
include_once '../../app_cotacao/Model/Model.php';
include_once '../../app_cotacao/Model/Cliente.php';

$cliente = new Cliente();
$cliente->__set('id',$_SESSION['id']);
$cliente->__set('company_name',$_SESSION['company_name']);
$cliente->__set('ultimo_pedido',$_GET['pedido']);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    
    <script src="https://kit.fontawesome.com/170e4c5383.js" crossorigin="anonymous"></script>

    <!-- Scripts Jquery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>


    <title>App Cotações - Cliente</title>
    <link rel="stylesheet" href="css/index.style.css">
    <script src="script.js"></script>
    
  
</head>

<body>

    <header class="navbar navbar-expand-sm navbar-dark navigation">
        <div class="navbar-brand">
            <img src="../appcotacao.webp" width="100" alt="">
        </div>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#nav-principal">
            <i class="fas fa-bars text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="nav-principal">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="./index.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a href="../route.php?route=logoff" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logoff</a>
                </li>
            </ul>
        </div>
    </header>

    <section class="container">
        <div class="row">
            <div class="col-md-12 box-cotacoes mt-4">
                <span>Cotação <i class="perfil-contador"><?=$cliente->__get('ultimo_pedido')?></i> </span>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <td>Descrição</td>
                            <td>Remover</td>
                        </tr>
                    </thead>

                    <tbody id="tabela-itens">
                        <? foreach($cliente->getItensPedido() as $index=>$item){?>
                            <tr id="item_<?=$item['id']?>">
                                <td>
                                   <?=$item['descricao']?>
                                </td>
                                <td onclick="removerItemPedido(<?=$item['id']?>)">
                                    <i class="far fa-trash-alt"></i>
                                </td>
                            </tr>
                        <?}?>

                    </tbody>
                </table>

                <div class="input-group mt-5">
                    <input id="busca-descricao" type="text" class="form-control" placeholder="Descrição">
                    <button class="btn btn-outline-info" type="button" onclick="buscarProduto()">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-outline-danger" type="button" onclick="limparCampos()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <table class="table table-dark mt-2">
                    <tbody id="table-busca">
                        <!-- <tr>
                            <td>
                                Farinha de Trigo Dona Benta 1KG
                            </td>
                            <td>
                                <i class="fas fa-cart-plus"></i>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script>
        $('#busca-descricao').on('keypress', function(e){
            if(e.which == 13){
                buscarProduto()
            }
        })
    </script>
</body>

</html>