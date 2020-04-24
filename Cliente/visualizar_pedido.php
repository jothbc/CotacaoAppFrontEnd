<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['company_name'])) {
    header("Location: ../route.php?route=logoff");
}
if(!isset($_GET['pedido'])){
    header("Location: index.php");
}
include_once '../../app_cotacao/Connection.php';
include_once '../../app_cotacao/Model/Model.php';
include_once '../../app_cotacao/Model/Cliente.php';

$cliente = new Cliente();
$cliente->__set('id',$_SESSION['id']);
$cliente->__set('company_name',$_SESSION['company_name']);
$cliente->__set('ultimo_pedido',$_GET['pedido']);

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
        <span class="text-info"><strong>Cotação</strong> <i class="perfil-contador"><?=$cliente->__get('ultimo_pedido')?></i> </span>
        
        <? foreach($cliente->getItensPedido() as $index=>$item){?>
            <div class="row" id="item_<?=$item['id']?>">
                <div class="col-md-12 box-cotacoes mt-4">

                    <!-- div descrição do item -->
                    <div class="row">
                        <div class="col-12 text-info">
                            <h4>
                                <?=$item['descricao']?>
                            </h4>
                        </div>
                    </div>
                    <!-- fim div descricao item -->

                    <!-- Fornecedores -->
                    <div class="row">
                        <div class="col-12">
                            <div style="position: relative">
                                <!-- box dos fornecedores -->
                                <div class="btn btn-outline-info m-1 box">
                                    <div>Muffato</div>
                                    <div>R$ 12,99</div>
                                </div>

                                <div class="btn btn-outline-info m-1 box">
                                    <div>Joinvile</div>
                                    <div>R$ 13,99</div>
                                </div>

                                <div class="btn btn-outline-info m-1 box">
                                    <div>Muller</div>
                                    <div>R$ 11,99</div>
                                </div>

                                <div class="btn btn-outline-info m-1 box">
                                    <div>DEQUECH</div>
                                    <div>R$ 10,99</div>
                                </div>

                                <div class="btn btn-outline-info m-1 box">
                                    <div>PARATI</div>
                                    <div>R$ 9,98</div>
                                </div>

                                <div class="btn btn-outline-info m-1 box">
                                    <div>DEQUECH</div>
                                    <div>R$ 10,99</div>
                                </div>

                                <div class="btn btn-outline-info m-1 box">
                                    <div>PARATI</div>
                                    <div>R$ 9,98</div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <!-- FIM Fornecedores -->

                    <!-- Ao clicar no fornecedor deve aparecer essa div para informar ao fornecedor as obs do pedido -->
                    <!-- inicio obs -->
                    <div class="row mt-2">
                        <div class="col-12 input-group">
                            <input type="text" placeholder="Observação: Ex: 1CX de cada sabor" class="form-control">
                            <button class="btn btn-outline-info"><i class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>
                    <!-- fim obs -->
                </div>
            </div>
        <?}?>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>