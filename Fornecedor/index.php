<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['company_name'])) {
    header("Location: ../route.php?route=logoff");
}
include_once '../../app_cotacao/Connection.php';
include_once '../../app_cotacao/Model/Model.php';
include_once '../../app_cotacao/Model/Fornecedor.php';

$fornecedor = new Fornecedor();
$fornecedor->__set('id', $_SESSION['id']);
$fornecedor->__set('company_name', $_SESSION['company_name']);
$info_fornecedor = $fornecedor->getInfo();
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

    <title>App Cotações - Fornecedor</title>
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
                    <h4 class="perfil-empresa justify-content-center d-flex">
                        <?= $info_fornecedor['company_name'] ?>
                    </h4>
                    <small class="d-flex">
                        <div class="mr-2">
                            Email: <a href=""><?= $info_fornecedor['email'] ?></a>
                        </div>
                        <div class="mr-2">
                            CNPJ: <?= $info_fornecedor['cnpj'] ?>
                        </div>
                       
                    </small>
                    <small class="mt-2">
                        Tel: <?= $info_fornecedor['tel'] ?>
                        <?= $info_fornecedor['tel_2']!=''?'Tel2: '.$info_fornecedor['tel_2']:''?>
                    </small>
                    <div class="d-flex justify-content-end">
                        <a href="perfil.php"><i class="fas fa-user-edit edit_perfil"></i></a>
                    </div>
                </div>
                <div class="box-perfil mt-4">
                    <h4 class="text-center">Buscar Cliente</h4>
                    <div class="input-group">
                        <input class="form-control" type="text" id="empresa" placeholder="Empresa">
                        <button class="btn btn-outline-info" onclick="procurarCliente()"> <i class="fas fa-plus"></i> </button>
                    </div>
                    <div class="ml-2 mr-2" id="busca_cliente">
                        <!-- conteudo da busca de cliente por cnpj ou company_name -->
                    </div>
                </div>
            </div>

            <div class="col-md-8">

                <div class="mt-4 box-cotacoes">
                    <button class="btn btn-outline-white" data-toggle="collapse" data-target="#collapseTable">
                        Clientes <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="collapse show" id="collapseTable">
                        <table class="table table-dark ">
                            <tbody id="table-clientes">
                                <? foreach ($fornecedor->getClientes() as $cli) { ?>
                                    <tr id="cliente_id_<?= $cli['cliente_id'] ?>">
                                        <td onclick="buscarCotacoes(<?= $cli['cliente_id'] ?>)">
                                            <?= $cli['company_name'] ?>
                                        </td>
                                        <td onclick="buscarCotacoes(<?= $cli['cliente_id'] ?>)">
                                            CNPJ: <?= $cli['cnpj'] ?>
                                        </td>
                                        <td onclick="removerCliente(<?= $cli['cliente_id'] ?>)">
                                            <i class="far fa-trash-alt"></i>
                                        </td>
                                    </tr>
                                <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3 box-cotacoes" id="cotacoes" hidden>
                    <span id="cliente_company" class="text-dark">Cotações </span> <i class="fas fa-chevron-down"></i>
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <td>Pedido</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody id="table-cliente-cotacao">
                            <!-- conteudo da cotação -->
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
                        Perfil atualizado com sucesso!
                    </div>
                <?}
                else if($_GET['editPerfil'] == 'fail'){?>
                    <div class="text-danger" id="footer-dialog">
                        Erro ao tentar atualizar o perfil. Tente mais tarde.
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