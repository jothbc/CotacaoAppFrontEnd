<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['company_name'])) {
    header("Location: ../route.php?route=logoff");
}
require_once '../../app_cotacao/Connection.php';
require_once '../../app_cotacao/Model/Model.php';
require_once '../../app_cotacao/Model/Cliente.php';

$cliente = new Cliente();
$cliente->__set('id',$_SESSION['id']);
$cliente->__set('company_name',$_SESSION['company_name']);
$infos = $cliente->getMinhasInfos();
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

            <div class="col-md-4">
                <div class="box-perfil mt-4">
                    <h4 class="perfil-empresa">
                        <?=$_SESSION['company_name']?>
                    </h4>
                    <div>
                        <span>
                            Total de Cotações 
                        </span>
                        <span class="perfil-contador"> 
                            <?=$cliente->getTotalPedidos()['total']?>
                        </span>
                    </div>
                    <div>
                        <small class="text-light">CNPJ: <?=$infos['cnpj']?></small> <br>
                        <small class="text-light">Email: <a href=""><?=$infos['email']?></a></small> <br>
                        <small class="text-light">Telefone: <?=$infos['tel']?> - <?=$infos['tel_2']?></small>
                    </div>
                    <div class="d-flex justify-content-end" style="margin-top: -20px;">
                        <a href="perfil.php"><i class="fas fa-user-edit edit_perfil"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="box-cotacoes mt-4">
                    <button class="btn btn-outline-warning btn-block text-dark" onclick="novoPedido()"><strong>Nova Cotação</strong></button>
                    <table class="table table-dark mt-2 rounded">
                        <thead>
                            <tr>
                                <td>Cotação</td>
                                <td>Status</td>
                                <td>Editar</td>
                                <td>Remover</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($cliente->getPedidos() as $index=>$pedido){?>
                                <tr id="pedido_<?=$pedido['pedido']?>">
                                    <td onclick="visualizarPedido(<?=$pedido['pedido']?>)">
                                        <?=$pedido['pedido']?>
                                    </td>

                                    <td onclick="visualizarPedido(<?=$pedido['pedido']?>)">
                                        <?=$pedido['descricao']?>
                                    </td>

                                    <?if($pedido['status'] == 1){?>
                                        <td onclick="editarPedido(<?=$pedido['pedido']?>)" >
                                            <i class="far fa-edit"></i>
                                        </td>
                                    <?}else{?>
                                        <td></td>
                                    <?}?>

                                    <td onclick="removerPedido(<?=$pedido['pedido']?>)">
                                        <i class="far fa-trash-alt"></i>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </section>

    <footer style="position: fixed; bottom: 5px;left: 5px">
        <? if (isset($_GET['editPerfil'])){
                if($_GET['editPerfil'] == 'success'){ ?>
                    <div class="text-success" id="footer-dialog">
                        <span>Perfil atualizado com sucesso!</span>
                    </div>
                <?}
                else if($_GET['editPerfil'] == 'fail'){?>
                    <div class="text-danger" id="footer-dialog">
                        <span>Erro ao tentar atualizar o perfil. Tente mais tarde.</span>
                    </div>
                <?}?>
        <? } ?>
    </footer>
   
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
    <script>
        $(document).ready(
            setTimeout(() => {
                $("#footer-dialog").remove();
            }, 3000)
        )
    </script>

</body>

</html>