<?php
session_start();

if (!isset($_SESSION['authenticate']) && $_SESSION['authenticate'] != 'yes') {
    session_destroy();
    header("Location: ../index.php?erro=login");
}

if (isset($_GET['pedido'])) {
    $_SESSION['pedido'] = $_GET['pedido'];
}

require_once "../../app_cotacao/Cliente/Lista/Lista.php";
require_once "../../app_cotacao/Cliente/Lista/Lista.Service.php";
require_once "../../app_cotacao/Conexao/JDBC.php";

$lista = new Lista();
$lista->__set('cliente_id', $_SESSION['id'])
    ->__set('pedido_id', $_SESSION['pedido']);

$lista_service = new ListaService($lista, new Conexao());
$status_pedido = $lista_service->getStatusPedido();
$lista_cliente = $lista_service->getListCliente();
$lista_fornecedores = $lista_service->getListFornecedores();

$colunas = 0;
$colunas_fornecedores_id = [];
foreach ($lista_cliente as $key => $item) {
    $lista_cliente[$key]['fornecedores'] = [];
    foreach ($lista_fornecedores as $k => $i) {
        if ($i['produto_id'] == $item['produto_id']) {
            array_push($lista_cliente[$key]['fornecedores'], $i);
            // obtem o numero máximo de colunas
            $colunas = $colunas < count($lista_cliente[$key]['fornecedores']) ? count($lista_cliente[$key]['fornecedores']) : $colunas;
        }
    }
}

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- <link rel="stylesheet" href="../fontawesome/css/all.min.css"> -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Cliente/style.css">
    <title><?= $_SESSION['company_name'] ?> - Cliente</title>

    <script src="script.js"></script>

</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="navbar-brand">
            <?=$_SESSION['company_name']?>
        </div>    
        <button class="navbar-toggler" data-toggle="collapse" data-target="#nav-principal">
            <i class="fas fa-bars text-white"></i>
        </button>
        <div id="nav-principal" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="../Cliente/index.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a href="../logoff.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logoff</a>
                </li>
            </ul>
        </div>
    </nav>
    <section class="container">
        <div class="row">
            <div class="col-md-12 box-container">
                <div>
                    <h3 class="text-white">
                        <?=$_SESSION['company_name']?>  
                    </h3>
                    <h5 class="text-info">
                        Pedido <?=$_SESSION['pedido']?>
                    </h5>
                </div>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <td>Descrição</td>
                            <?
                            //percorre todos os items
                            foreach ($lista_cliente as $key => $item) {
                                //percorre todos os fornecedores do item em questao
                                foreach ($item['fornecedores'] as $k => $i) {

                                    //verifica se é um fornecedor novo, se for é incluido o id desse fornecedor no array e é criado a coluna
                                    //metodo array_search nao funcionou aqui
                                    if (!in_array($i['fornecedor_id'], $colunas_fornecedores_id)) {
                                        array_push($colunas_fornecedores_id, $i['fornecedor_id']);

                            ?>

                                        <td id="coluna_fornecedor_id_<?= $i['fornecedor_id'] ?>">
                                            <?= $i['company_name'] ?>
                                        </td>

                            <?
                                    }
                                }
                            }
                            ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?
                        //percorrendo item por item
                        foreach ($lista_cliente as $key => $item) {
                        ?>
                            <tr class="data-table">
                                <td><?= $item['descricao'] ?></td>
                                <?
                                //percorre todas as colunas pelo id do fornecedor
                                foreach ($colunas_fornecedores_id as $forn_) {

                                    //variavél para verificar se essa coluna foi criado o td
                                    //caso nao tenha sido criado, é criado no if la em baixo
                                    $include = false;
                                    //percorrendo os fornecedores que cotaram o item em questao
                                    foreach ($item['fornecedores'] as $forn) {

                                        //se o id da coluna for o mesmo que o fornecedor em questao aplica o preço
                                        if ($forn_ == $forn['fornecedor_id']) {
                                            $include = true;
                                ?>
                                            <td onclick="marcar(<?= $forn['produto_id'] ?>,<?= $forn['fornecedor_id'] ?>,<?= $_SESSION['id'] ?>,<?= $_SESSION['pedido'] ?>)" id="<?= $forn['produto_id'] ?>_<?= $forn['fornecedor_id'] ?>">

                                                R$ <?= number_format($forn['valor'], 2, ',', '.') ?>
                                                <? if ($forn['aprovado']) { ?>
                                                    <i class="far fa-check-square"></i>
                                                <? } ?>
                                            </td>
                                        <?
                                        }
                                    }
                                    if (!$include) {
                                        ?>
                                        <td>
                                            <i class="fas fa-times"></i>
                                        </td>
                                <?
                                    }
                                }
                                ?>
                            </tr>
                        <?
                        }
                        ?>

                    </tbody>
                </table>
                <div>
                    <button class="btn btn-outline-info btn-block mt-4" onclick="fechar_abrir_pedido(<?=$_SESSION['id']?> , <?=$_SESSION['pedido']?> )">
                        <?= $status_pedido['status']==1 ? 'Fechar Pedido':'Reabrir Pedido' ?>
                    </button>
                </div>
            </div>
        </div>
    </section>


    <!-- Scripts Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>