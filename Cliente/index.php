<?php
session_start();

if (!isset($_SESSION['authenticate']) && $_SESSION['authenticate'] != 'yes') {
    session_destroy();
    header("Location: ../index.php?erro=login");
}

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="../fontawesome/css/all.min.css">

    <link rel="stylesheet" href="./style.css">
    <title><?= $_SESSION['company_name'] ?> - Cliente</title>

    <script>
        function abrirCotacao(pedido) {
            window.location.href = './cotacao.php?pedido=' + pedido
        }

        function deletarCotacao(pedido) {
            window.location.href = './remover_cotacao.php?pedido=' + pedido
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
        <div class="box-container">

            <div>
                <form action="./nova_cotacao.php" class="form" method="POST">
                    <button class="btn btn-outline-success text-white btn-block">Nova Cotação</button>
                </form>
            </div>

            <div class="mt-3">
                <? if (isset($_GET['delete']) && $_GET['delete'] == 'fail') { ?>
                    <div class="text-danger delete-error">Falha ao tentar remover registro.</div>
                <? } else if (isset($_GET['delete']) && $_GET['delete'] == 'success') { ?>
                    <div class="text-success delete-error">Registro removido com sucesso.</div>
                <? } ?>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <td>
                                Código
                            </td>
                            <td>
                                Status
                            </td>
                            <td>
                                <!-- Espaço para incluir o botao de delete -->
                            </td>
                        </tr>
                    </thead>
                    <?
                    require_once '../../../app_cotacao/Conexao/JDBC.php';
                    require_once '../../../app_cotacao/Cliente/CotacaoClienteInfo.model.php';
                    require_once '../../../app_cotacao/Cliente/CotacaoClienteInfo.Service.php';
                    $cotacao = new CotacaoClienteInfo();
                    $cotacao->__set('cliente_id', $_SESSION['id']);

                    $service = new CotacaoClienteInfoService($cotacao, new Conexao());
                    $lista = $service->readAll();

                    foreach ($lista as $key => $value) { ?>
                        <tbody>
                            <tr class="data-table">
                                <td onclick="abrirCotacao('<?= $value['pedido'] ?>')">
                                    <?= $value['pedido'] ?>
                                </td>
                                <td onclick="abrirCotacao('<?= $value['pedido'] ?>')">
                                    <?= $value['descricao'] ?>
                                </td>
                                <td onclick="deletarCotacao('<?= $value['pedido'] ?>')">
                                    <i class="fas fa-trash-alt"></i>
                                </td>
                            </tr>
                        </tbody>
                    <? } ?>

                </table>
            </div>
        </div>
    </section>


    <!-- Scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
    <!-- scripts jquery -->
    <script>
        $(document).ready(
            setTimeout(() => {
                $('.delete-error').remove()
            }, 3000)
        )
    </script>
</body>

</html>