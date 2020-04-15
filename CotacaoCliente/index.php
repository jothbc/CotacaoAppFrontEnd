<?php
session_start();

if (!isset($_SESSION['authenticate']) && $_SESSION['authenticate'] != 'yes') {
    session_destroy();
    header("Location: ../index.php?erro=login");
}

if (isset($_GET['pedido'])) {
    $_SESSION['pedido'] = $_GET['pedido'];
}

require_once "../../../app_cotacao/Cliente/Lista/Lista.php";
require_once "../../../app_cotacao/Cliente/Lista/Lista.Service.php";
require_once "../../../app_cotacao/Conexao/JDBC.php";
$lista = new Lista();
$lista->__set('cliente_id', $_SESSION['id'])
    ->__set('pedido_id', $_SESSION['pedido']);

$lista_service = new ListaService($lista, new Conexao());
$lista_cliente = $lista_service->getListCliente();
$lista_fornecedores = $lista_service->getListFornecedores();

// echo '<pre>';
// print_r($lista_fornecedores);
// echo '</pre>';
// [0] => Array
// (
//     [id] => 30
//     [cliente_id] => 1
//     [pedido_id] => 5
//     [produto_id] => 12
//     [descricao] => Requeijão Tirol 200g
// )

// [0] => Array
// (
//     [id] => 21
//     [fornecedor_id] => 2
//     [pedido_id] => 5
//     [cliente_id] => 1
//     [produto_id] => 2
//     [valor] => 20.79
//     [aprovado] => 0
// )
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
// echo '<pre>';
// print_r($lista_cliente);
// echo '</pre>';
// echo $colunas;

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="../fontawesome/css/all.min.css">

    <link rel="stylesheet" href="../Cliente/style.css">
    <title><?= $_SESSION['company_name'] ?> - Cliente</title>

    <script>
        function marcar(produto_id,fornecedor_id){
            console.log(produto_id,fornecedor_id)
        }
    </script>

</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="../Cliente/index.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
            </li>
            <li class="nav-item">
                <a href="../logoff.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logoff</a>
            </li>
        </ul>
    </nav>
    <section class="container">
        <div class="row">
            <div class="col-md-12 box-container">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <td>Descrição</td>
                           <?
                                //percorre todos os items
                                foreach($lista_cliente as $key=>$item){
                                    //percorre todos os fornecedores do item em questao
                                    foreach($item['fornecedores'] as $k=>$i){
                                        //verifica se é um fornecedor novo, se for é incluido o id desse fornecedor no array e é criado a coluna
                                        if( !array_search($i['fornecedor_id'],$colunas_fornecedores_id) ){
                                            array_push($colunas_fornecedores_id,$i['fornecedor_id']);
                                            ?>
                                                <td id="coluna_fornecedor_id_<?=$i['fornecedor_id']?>">
                                                    <?=$i['company_name']?>
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
                            foreach($lista_cliente as $key=>$item){
                                ?>
                                    <tr class="data-table">
                                        <td><?=$item['descricao']?> ID <?=$item['produto_id']?></td>
                                        <?
                                            //percorrendo os fornecedores que cotaram o item em questao
                                            foreach($item['fornecedores'] as $k=>$forn){

                                                //percorre todas as colunas pelo id do fornecedor
                                                foreach($colunas_fornecedores_id as $index=>$forn_){
                                                    
                                                    //se o id da coluna for o mesmo que o fornecedor em questao aplica o preço
                                                    if($forn_ == $forn['fornecedor_id']){
                                                        ?>
                                                            <td onclick="marcar(<?=$forn['produto_id']?>,<?=$forn['fornecedor_id']?>)">
                                                                <?=$forn['valor']?>
                                                            </td>
                                                        <?
                                                    }

                                                }
                                            }
                                        ?>
                                    </tr>
                                <?
                            }
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

    <!-- scripts jquery -->
    <script>
        // $(document).ready(

        // )
    </script>
</body>

</html>