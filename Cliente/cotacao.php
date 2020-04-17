<?php
session_start();

if (!isset($_SESSION['authenticate']) && $_SESSION['authenticate'] != 'yes') {
    session_destroy();
    header("Location: ../index.php?erro=login");
}
if (isset($_GET['pedido'])) {
    $_SESSION['pedido'] = $_GET['pedido'];
}

require_once "../../app_cotacao/Conexao/JDBC.php";
require_once "../../app_cotacao/Produto/Produto.model.php";
require_once "../../app_cotacao/Produto/Produto.Service.php";
require_once '../../app_cotacao/Produto/ProdutoPedido.php';
require_once '../../app_cotacao/Produto/ProdutoPedido.Service.php';
require_once "../../app_cotacao/Cliente/CotacaoClienteInfo.model.php";
require_once "../../app_cotacao/Cliente/CotacaoClienteInfo.Service.php";

$cotacao = new CotacaoClienteInfo();
$cotacao->__set('cliente_id', $_SESSION['id']);
$cotacao->__set('pedido', $_SESSION['pedido']);

$service_cotacao = new CotacaoClienteInfoService($cotacao, new Conexao());
// $info_cotacao = $service_cotacao->read();

$status_inverso = $service_cotacao->getStatus()['status'] == 0 ? 'Aberto': 'Fechado';

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- <link rel="stylesheet" href="../fontawesome/css/all.min.css"> -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title><?= $_SESSION['company_name'] ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
        <div class="collapse navbar-collapse" id="nav-principal">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="./index.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a href="../logoff.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logoff</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Conteudo -->
    <section class="container">
        <!-- <div class="box-container div-lateral"> -->
        <div class="row mt-5">
            <!-- <div class="lateral-esq"> -->
            <div class="col-md-3 box">

                <span class="box-pedido d-block mb-1">PEDIDO: <?= $_SESSION['pedido'] ?></span>
                
                <div class="input-group">
                    <input id="produto_descricao" type="text" placeholder="Descrição" class="form-control" name="descricao">
                    <div class="input-group-append">
                        <button class="btn btn-success" onclick="buscarProduto()"><i class="fas fa-search"></i></button>
                    </div>
                </div>

                <table class="table table-dark">
                    <tbody id="table_result">
                       <!-- conteudo do bloco de notas -->
                        
                    </tbody>
                </table>
            </div>

            <!-- <div class="lateral-dir"> -->
            <div class="col-md-9 box">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <td>
                                Descrição
                            </td>
                        </tr>
                    </thead>
                    <tbody id="table_pedido">
                        <!-- Conteudo -->
                       
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 box text-white d-flex justify-content-end pr-5">
                <div>
                    <span>Alterar status do pedido para </span>
                    <button class="btn btn-outline-light m-1" onclick="inverterStatus()" id="btn_status_pedido"> <?= $status_inverso ?> </button>
                </div>
            </div>
        </div>
    </section>


    <!-- Scripts Bootstrap -->
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>