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
            <div class="col-md-12">
                <div class="mt-4">
                    <form action="../route.php?route=atualizarPerfilFornecedor" method="POST" serialize class="border border-secondary rounded p-2">
                        <h4>Atualizar Cadastro</h4>    
                        <label for="empresa">Empresa</label>
                        <input class="form-control" 
                                type="text" 
                                name="empresa" 
                                id="empresa" 
                                placeholder="Empresa" 
                                value="<?= $info_fornecedor['company_name'] ?>">
                        <br>
                        <label for="cnpj">CNPJ</label>
                        <input type="number" 
                                name="cnpj" 
                                id="cnpj" 
                                class="form-control" 
                                placeholder="CNPJ (somente números)" 
                                value="<?= $info_fornecedor['cnpj'] ?>">
                        <br>
                        <label>Contato</label>
                        <div class="form-row">
                            <div class="col">
                                <input type="tel" 
                                        name="tel" 
                                        id="tel" 
                                        class="form-control"
                                        placeholder="Telefone" 
                                        value="<?= $info_fornecedor['tel'] ?>">
                            </div>
                            <div class="col">
                                <input type="tel2" 
                                        name="tel2" 
                                        id="tel2" 
                                        class="form-control"
                                        placeholder="Telefone (não obrigatório)" 
                                        value="<?= $info_fornecedor['tel_2'] ?>">
                            </div>
                        </div>
                        <br>
                        <label for="email">Email</label>
                        <input type="email" 
                                name="email" 
                                id="email" 
                                class="form-control"
                                placeholder="Email" 
                                value="<?= $info_fornecedor['email'] ?>">

                        <div class="d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Salvar</button>
                        </div>
                    </form>

                    <form action="../route.php?route=atualizarSenhaFornecedor" method="POST" class="border border-secondary rounded p-2 mt-4">
                        <h4>Atualizar Senha</h4>
                        <label for="senha">Senha atual</label>
                        <input type="password" 
                                name="pass_atual" 
                                id="senha" 
                                placeholder="Senha Atual" 
                                class="form-control">
                        <br>
                        <label for="nova-senha">Nova senha</label>
                        <input type="password" 
                                name="pass_novo" 
                                id="nova-senha" 
                                placeholder="Nova Senha" 
                                class="form-control
                                <?=isset($_GET['pass'])&&($_GET['pass'])=='diferent'?'is-invalid':''?>
                                ">
                        <br>
                        <label for="nova-senha2">Confirmação da nova senha</label>
                        <input type="password" 
                                name="pass_novo2" 
                                id="nova-senha2" 
                                placeholder="Confirme sua nova senha" 
                                class="form-control
                                <?=isset($_GET['pass'])&&($_GET['pass'])=='diferent'?'is-invalid':''?>
                                ">
                        <div class="d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Salvar</button>
                        </div>
                    </form>
                   
                </div>
                
            </div>

        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>

</html>