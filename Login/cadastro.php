<?php
// session_start();
// if (!isset($_GET['tipo'])) {
//     header("Location: ../index.php");
// }
// $_SESSION['tipo'] = $_GET['tipo'];
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/170e4c5383.js" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="../style.css">
    <title><?= $_SESSION['company_name'] ?> - Cliente</title>

</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="../logoff.php" class="nav-link"><i class="fas fa-arrow-left"></i></i> Voltar</a>
            </li>
        </ul>
    </nav>
    <section class="container">
        <div class="row">
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">Cadastro</div>
                    <div class="card-body">
                        <form action="./novo_cadastro.php" method="POST">
                            <label for="email">Pessoal</label>
                            <input type="email" placeholder="Email" class="form-control" name="email" required>
                            <input type="password" name="pass" id="pass" placeholder="Senha" class="form-control mt-1" required>
                            <input type="password" name="pass2" id="pass2" placeholder="Confirme sua senha" class="form-control mt-1" required>
                            <input type="tel" name="tel" id="tel" placeholder="Telefone" class="form-control mt-1" required>
                            <input type="tel" name="tel2" id="tel2" placeholder="Telefone 2 (não obrigatório)" class="form-control mt-1">
                            <br>
                            <label for="company_name">Empresa</label>
                            <input type="text" name="company_name" id="empresa" placeholder="Empresa" class="form-control mt-1" required>
                            <input type="number" name="cnpj" id="cnpj" placeholder="CNPJ" class="form-control mt-1" required>
                            <br>
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>