<?php
session_start();

if (!isset($_SESSION['authenticate']) && $_SESSION['authenticate'] != 'yes') {
    session_destroy();
    header("Location: ../index.php?erro=login");
}
if(isset($_GET['pedido'])){
    $_SESSION['pedido'] = $_GET['pedido'];
}

require_once "../../../app_cotacao/Conexao/JDBC.php";
require_once "../../../app_cotacao/Produto/Produto.model.php";
require_once "../../../app_cotacao/Produto/Produto.Service.php";

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="../fontawesome/css/all.min.css">

    <link rel="stylesheet" href="./style.css">
    <title><?= $_SESSION['company_name'] ?></title>

    <script>
        function inserirItem(item_id,pedido){
            window.location.href = "./adicionar_item_cotacao.php?item_id="+item_id+"&pedido="+pedido
        }
        function removerItemDaCotacao(id_item_cotacao){
            window.location.href = "./remover_item_cotacao.php?id_item_cotacao="+id_item_cotacao
        }
        function novoItem(descricao,pedido){
            console.log(descricao,pedido)
            window.location.href = "./adicionar_item_cotacao.php?novo="+descricao+"&pedido="+pedido
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="./index.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
            </li>
            <li class="nav-item">
                <a href="../logoff.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logoff</a>
            </li>
        </ul>
    </nav>
    <section class="container">
        <!-- <div class="box-container div-lateral"> -->
        <div class="row mt-5">
            <!-- <div class="lateral-esq"> -->
            <div class="col-md-3 box">
                <span class="box-pedido">PEDIDO: <?=$_SESSION['pedido']?></span>
                <form action="./cotacao.php" method="POST">
                    <div class="input-group">
                        <input type="text" placeholder="Descrição" class="form-control" name="descricao">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
                <table class="table table-dark">
                    <tbody>
                        <?
                        if (isset($_POST['descricao'])) {
                            $produto = new Produto();
                            $produto->__set('descricao', $_POST['descricao']);

                            $service = new ProdutoService($produto, new Conexao());
                            $lista = $service->read('descricao');

                            foreach ($lista as $key => $item) { ?>
                                <tr>
                                    <td> <?= $item['descricao'] ?></td>
                                    <td onclick="inserirItem(<?=$item['id']?>,<?=$_SESSION['pedido']?>)"><i class="fas fa-arrow-right"></i></td>
                                </tr>
                            <? }

                            //Se for uma string maior que 5 caracteres
                            if (strlen($_POST['descricao']) > 5) { ?>
                                <tr>
                                    <td><?=$_POST['descricao']?></td>
                                    <td onclick="novoItem('<?=$_POST['descricao']?>',<?=$_SESSION['pedido']?>)"><i class="fas fa-plus"></i></i></td>
                                </tr>
                        <?  }
                        }
                        ?>

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
                    <tbody>
                        <!-- vou ter que pré-carregar a lista vinda da $_SESSION['pedido'] -->
                        <!-- TEMPORARIO -->
                        <?
                            require_once '../../../app_cotacao/Produto/ProdutoPedido.php';
                            require_once '../../../app_cotacao/Produto/ProdutoPedido.Service.php';
                            $pedido = new ProdutoPedido();
                            $pedido->__set('cliente_id',$_SESSION['id']);
                            $pedido->__set('pedido_id',$_SESSION['pedido']);

                            $service = new ProdutoPedidoService($pedido, new Conexao());
                            $lista = $service->readAll();

                            foreach($lista as $key => $item){ ?>

                                <tr>
                                    <td><?=$item['descricao']?></td>
                                    <td onclick="removerItemDaCotacao(<?=$item['id']?>)"> <i class="fas fa-trash-alt"></i></td>
                                </tr>

                            <?}
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <!-- Scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>