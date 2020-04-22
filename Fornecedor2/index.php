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

    <script src="https://kit.fontawesome.com/170e4c5383.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./style.css">
    <title><?= $_SESSION['company_name'] ?> - Fornecedor</title>

    <script>
       
    </script>

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
                    <a href="./index.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
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
                <form action="./ver_cotacao.php" method="POST" class="form text-white">
                    <label for="pedido">Buscar Cotação</label>   
                    <input name="pedido" type="number" placeholder="Pedido" class="form-control" required>
                    <input name="cnpj" type="number" placeholder="CNPJ (somente números)" class="form-control mt-1" required> 
                    <button type="submit" class="btn btn-outline-info btn-block mt-1">Buscar</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- scripts jquery -->
    
</body>

</html>