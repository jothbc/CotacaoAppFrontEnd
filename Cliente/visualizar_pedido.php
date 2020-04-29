<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['company_name'])) {
    header("Location: ../route.php?route=logoff");
}
if (!isset($_GET['pedido'])) {
    header("Location: index.php");
}
include_once '../../app_cotacao/Connection.php';
include_once '../../app_cotacao/Model/Model.php';
include_once '../../app_cotacao/Model/Cliente.php';

$cliente = new Cliente();
$cliente->__set('id', $_SESSION['id']);
$cliente->__set('company_name', $_SESSION['company_name']);
$cliente->__set('ultimo_pedido', $_GET['pedido']);

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

    <section class="container mt-4">
        <div>
            <span class="text-info"><strong>Cotação</strong> <i class="perfil-contador"><?= $cliente->__get('ultimo_pedido') ?></i> </span>
            <button id="btn-status" class="ml-4 btn btn-outline-primary" onclick="inverterStatus(<?= $cliente->__get('id') ?>,<?= $cliente->__get('ultimo_pedido') ?>)"><?= $cliente->getStatusPedido()['status'] == 1 ? 'Fechar' : 'Abrir' ?></button>
        </div>

        <? foreach ($cliente->getItensPedido() as $index => $item) { ?>
            <div class="row" id="item_<?= $item['id'] ?>">
                <div class="col-md-12 box-cotacoes mt-4">

                    <!-- div descrição do item -->
                    <div class="row">
                        <div class="col-12 text-dark">
                            <h4>
                                <?= $item['descricao'] ?>
                            </h4>
                            <? if($item['pretencao']!=''){ ?>
                                <small class="ml-3">Pretenção: <?=$item['pretencao']?></small>
                            <? } ?>
                        </div>
                    </div>
                    <!-- fim div descricao item -->

                    <!-- Fornecedores -->
                    <div class="row">
                        <div class="col-12">
                            <div style="position: relative">
                                <!-- box dos fornecedores -->

                                <? foreach ($cliente->getValorCotadoParaProduto($item['produto_id']) as $index => $emp) { ?>
                                    <!-- DIV EXTERIOR ext_forn_[fornecedor_id]_item_[produto_id] -->
                                    <div id="ext_forn_<?= $emp['fornecedor_id'] ?>_item_<?= $item['produto_id'] ?>" class="m-1 box p-2">

                                        <!-- DIV INTERIOR forn_['fornecedor_id']_item_['produto_id'] -->
                                        <!-- Class active para itens aprovado -->
                                        <div id="forn_<?= $emp['fornecedor_id'] ?>_item_<?= $item['produto_id'] ?>" class="<?= $emp['aprovado'] == 1 ? 'active' : '' ?>">

                                            <!-- Nome da Empresa -->
                                            <div class="ml-2 text-dark">
                                                <strong><?= $emp['company_name'] ?></strong>
                                            </div>

                                            <!-- Valor -->
                                            <div class="ml-4 text-dark">
                                                R$ <?= number_format($emp['valor'], 2, ',', '.') ?>
                                                <span class="ml-2 text-primary span-link"
                                                    onclick="aprovarDesaprovar(<?= $emp['fornecedor_id'] ?>,<?= $cliente->__get('id') ?>,<?= $cliente->__get('ultimo_pedido') ?>,<?= $item['produto_id'] ?>)">
                                                    <?= $emp['aprovado'] == 1 ? 'Reprovar' : 'Aprovar' ?>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- FIM DIV INTERIOR forn_['fornecedor_id']_item_['produto_id'] -->

                                        <!-- DIV OBS -->
                                        <? if ($emp['aprovado'] == 1) { ?>
                                            <div class="input-group" 
                                                id="input_forn_<?= $emp['fornecedor_id'] ?>_item_<?= $item['produto_id'] ?>">

                                                    <input id="obs_text_forn_<?= $emp['fornecedor_id'] ?>_item_<?= $item['produto_id'] ?>" 
                                                            type="text" 
                                                            placeholder="Obs" 
                                                            class="form-control" 
                                                            value="<?= $emp['obs'] != '' ? $emp['obs'] : '' ?>" 
                                                            style="height: 20px">

                                                    <div class="pl-2 pr-2 mr-2 bg-primary" 
                                                        onclick="incluirObs(<?= $emp['fornecedor_id'] ?>,<?= $cliente->__get('id') ?>,<?= $cliente->__get('ultimo_pedido') ?>,<?= $item['produto_id'] ?>)">
                                                            <i class="fas fa-arrow-right"></i>
                                                    </div>

                                            </div>
                                        <? } ?>
                                        <!-- FIM DIV OBS -->

                                    </div>
                                    <!-- FIM DIV EXTERIOR ext_forn_[fornecedor_id]_item_[produto_id] -->
                                <? } ?>

                            </div>
                        </div>
                    </div>
                    <!-- FIM Fornecedores -->

                </div>
            </div>
        <? } ?>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>