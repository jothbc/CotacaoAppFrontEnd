<?php
session_start();

if (!isset($_SESSION['authenticate']) && $_SESSION['authenticate'] != 'yes') {
    session_destroy();
    header("Location: ../index.php?erro=login");
}
$cotacao = $_POST['pedido'];
$cnpj = $_POST['cnpj'];
// print_r($_SESSION);


require_once "../../../app_cotacao/Fornecedor/Lista/Lista.php";
require_once "../../../app_cotacao/Fornecedor/Lista/Lista.Service.php";
require_once "../../../app_cotacao/Conexao/JDBC.php";

$lista_cliente = (new ListaService(new Lista(), new Conexao()))->readAllList($cnpj, $cotacao);
$lista_ja_informado = (new ListaService(new Lista(),new Conexao()))->readAllInformado($cnpj,$cotacao,$_SESSION['id']);
if(!empty($lista_cliente)){
    $_SESSION['pedido'] = $cotacao;
    $_SESSION['cliente_id'] = $lista_cliente[0]['cliente_id'];
    foreach($lista_cliente as $key=>$item){
        foreach($lista_ja_informado as $k=>$i){
            if($item['produto_id']==$i['produto_id']){

                // nao é igual java, pra modificar o vetor é preciso acessar o respectivo local
                $lista_cliente[$key]['valor'] = $i['valor'];
                $lista_cliente[$key]['aprovado'] = $i['aprovado'];

            }
        }
    }
}

// echo '<pre>';
// print_r($lista_cliente);
// echo '</pre>';

//LISTA JA INFORMADO
// [0] => Array
//         (
//             [id] => 7
//             [fornecedor_id] => 0
//             [pedido_id] => 5
//             [cliente_id] => 1
//             [produto_id] => 1
//             [valor] => 6
//             [aprovado] => 0
//         )

//LISTA CLIENTE
// [0] => Array
// (
//     [cliente_id] => 1
//     [company_name] => Supermercado Correia
//     [pedido_id] => 5
//     [produto_id] => 10
//     [descricao] => mais items do que cabe
// )
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="../fontawesome/css/all.min.css">

    <link rel="stylesheet" href="./style.css">
    <title><?= $_SESSION['company_name'] ?> - Fornecedor</title>

    <script>
        function voltar() {
            window.location.href = "./index.php"
        }

        function removeItemDaVisualizacao(linha) {
            $('#' + linha).remove()
        }

        function definirValores() {
            let lista = []
            $('#table-body tr input').each(function(index, element) {
                if(element.value > 0){
                    lista[index] = {
                        id_prod:(element.id).substring(8),
                        valor: element.value
                    }
                }
            })
            $.ajax({
                type: 'post',
                url: 'definir_valores.php',
                data: {dado:lista},
                // dataType: 'json',
                success: data =>{
                    // console.log(data)
                    window.location.href = 'index.php?pedido=success'
                },
                error: erro=>{alert(erro)}                
            })
            

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
        <div class="row">
            <div class="col-md-12 box-container justify-content-center">
                <!-- controle de lista_cliente$lista_cliente vazia ou inesistente -->
                <? if (empty($lista_cliente)) { ?>
                    <button onclick="voltar()" type="button" class="btn btn-info"><i class="fas fa-arrow-left"></i> Voltar</button>
                    <h3 class="text-info" style="font-weight: 1">
                        <hr>Lista vazia. <br>
                        <hr>
                        1º Verifique se o número do pedido está correto e CNPJ. <br>
                    </h3>
                <? }else if($lista_cliente[0]['status']==0){ ?>
                    <!-- PEDIDO ENCERRADO -->
                    <!-- VER SE O CLIENTE APROVOU ALGUM VALOR -->
                    <h4 class="text-white"><?= $lista_cliente[0]['company_name'] ?></h4>
                    <h4 class="text-danger">Encerrado</h4>
                    
                    <table class="table table-dark" style="margin: 0px -10px;">
                        <thead>
                            <tr>
                                <td>Descrição</td>
                                <td>Valor</td>
                            </tr>
                        </thead>
                        <tbody id="table-body">

                            <? foreach ($lista_cliente as $key => $item) { 
                                    if(isset($item['aprovado']) && $item['aprovado']==1){?>

                                        <tr class="data-table">
                                            <td>
                                                <?= $item['descricao'] ?>
                                            </td>
                                            <td style="width: 20%; min-width: 100px" class="text-success">
                                                <!-- ID DO PRODUTO E VALOR -->
                                                <?='R$ '.$item['valor']?>
                                            </td>
                                        </tr>

                                <? }
                            } ?>

                        </tbody>
                    </table>



                <? } else { ?>

                    <h4 class="text-white"><?= $lista_cliente[0]['company_name'] ?></h4>

                    <table class="table table-dark" style="margin: 0px -10px;">
                        <thead>
                            <tr>
                                <td></td>
                                <td>Descrição</td>
                                <td>Valor</td>
                            </tr>
                        </thead>
                        <tbody id="table-body">

                            <? foreach ($lista_cliente as $key => $item) { ?>

                                <tr id="item_<?= $key ?>" class="data-table">
                                    <td onclick="removeItemDaVisualizacao('item_<?= $key ?>')">
                                        <i class="fas fa-times"></i>
                                    </td>
                                    <td>
                                        <?= $item['descricao'] ?>
                                    </td>
                                    <td style="width: 20%; min-width: 100px">
                                        <!-- ID DO PRODUTO E VALOR -->
                                        <input id="prod_id_<?= $item['produto_id'] ?>" class="form-control" type="number" name="valor" placeholder="R$" value="<?=isset($item['valor'])?$item['valor']:''?>">
                                    </td>
                                </tr>


                            <? } ?>

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mr-4 mt-4">
                        <button onclick="definirValores()" type="button" class="btn btn-success"><i class="fas fa-check"></i> Finalizar</button>
                    </div>
                <? }
                ?>


            </div>
        </div>
    </section>

    <!-- Scripts Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- scripts jquery -->
    <script>
        $(document).ready(() => {

        })
    </script>
</body>

</html>