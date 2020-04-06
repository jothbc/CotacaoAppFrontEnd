<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
    <title>Supermercado Correia - Login</title>

</head>

<body>

    <div class="container menu">
        <div class="row bloco">
            <div class="col mr-5">
                <div class="card">
                    <div class="card-header align-self-center">
                        <label for="email" class="cliente">Área do Cliente</label>
                    </div>
                    <div class="card-body">
                        <form action="./Login/login.php" method="POST">
                            <input name="cliente" value=1 hidden>
                            <input class="form-control" type="text" name="email" id="email" placeholder="Email" required>
                            <input class="form-control mt-1" type="password" name="senha" id="senha" placeholder="Senha" required>
                            <button class="btn btn-dark mt-2">Logar</button>
                        </form>
                        <a href="" class="inscricao text-info">Inscrever-se</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header align-self-center">
                        <label for="emailfornecedor" class="fornecedor">Área do Fornecedor</label>
                    </div>
                    <div class="card-body">
                        <form action="./Login/login.php" method="POST">
                            <input name="fornecedor" value=1 hidden>
                            <input class="form-control" type="text" name="email" id="emailfornecedor" placeholder="Email" required>
                            <input class="form-control mt-1" type="password" name="senha" id="senhafornecedor" placeholder="Senha" required>
                            <button class="btn btn-dark mt-2">Logar</button>
                        </form>
                        <a href="" class="inscricao text-info">Inscrever-se</a>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <!-- Scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>