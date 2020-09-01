<?php
if(!isset($_SESSION)){
    session_start();

    $usuario = $_SESSION['usuario'];
    $codUsuario = $_SESSION['codPessoa'];
}

?>

<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../node_modules/bootstrap/compiler/bootstrap.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/compiler/style.css">

    <title>Biblio.tech</title>
</head>

<body>
    <nav class="navbar navbar-fixed-top site-header sticky-top py-1 navbar-expand-lg navbar-dark bg-gradient-dark">
        <input type='button' class="btn btn-success font-weigth-bold" value='Voltar' onclick='history.back()' />
        <div class="container">
            

            <a class="navbar-brand h1 mb-0" href="index.php"><img src="../img/logo.png" alt="Logo.png" width="100px"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSite">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSite">
                <ul class="navbar-nav mr-auto font-weight-bold" style="font-size: 1.3rem;">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="livros.php" class="nav-link">Livros</a>
                    </li>
                    <!--li class="nav-item">
                        <a href="alunos.php" class="nav-link">Alunos</a>
                    </li>
                    <li class="nav-item">
                        <a href="emprestimos.php" class="nav-link">Empréstimos</a>
                    </li-->
                </ul>
                <h3></h3>
                <ul class="navbar-nav ml-auto" style="font-size: 1.1rem;">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Olá <?= $usuario ?></a>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item">Ver Perfil</a>
                            <a href="#" class="dropdown-item">Configurações</a>
                            <a href="../controller/logout.php" class="dropdown-item">Sair</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Ajuda</a>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item">Fale com a biblioteca</a>
                            <a href="#" class="dropdown-item">Relatar Problema</a>
                            <a href="#" class="dropdown-item">Pendências</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Optional JavaScript -->
     <!-- jQuery first, then Popper.js, then Bootstrap JS -->
     <script src="../node_modules/jquery/dist/jquery.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
</body>

</html>