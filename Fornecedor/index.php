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
                <?php $info_fornecedor = $fornecedor->getInfo(); ?>
                <div class="box-perfil mt-4">
                    <h4 class="perfil-empresa justify-content-center d-flex">
                        <?= $info_fornecedor['company_name'] ?>
                    </h4>
                    <small>
                        Email: <a href=""><?= $info_fornecedor['email'] ?></a>
                        <br>
                        CNPJ: <?= $info_fornecedor['cnpj'] ?>
                    </small>
                </div>
            </div>

            <div class="col-md-8 box-cotacoes mt-4">
                <div class="input-group">
                    <input class="form-control" type="number" name="cnpj" id="cnpj" placeholder="CNPJ (somente números)">
                    <button class="btn btn-outline-info" onclick="adicionarCliente()"> <i class="fas fa-plus"></i> </button>

                </div>
                <small id="noCliente" class="text-danger" hidden>*Cliente não localizado</small>

                <div class="mt-3">

                    <h4>Clientes <i class="fas fa-chevron-down"></i></h4>
                    <table class="table table-dark">
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

                <div class="mt-3" id="cotacoes" hidden>
                    Cotações <span id="cliente_company"></span> <i class="fas fa-chevron-down"></i>
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


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>

</html>