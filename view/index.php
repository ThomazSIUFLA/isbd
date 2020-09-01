<?php
include './header.php';
include './footer.html';

?>

<body style="background-image: url('../img/fundo.jpg');" >

    <span class="d-block p-2 bg-gradient-dark text-info font-weight-bold h2 text-center">HOME</span>
    
    <div class="row container m-auto">
    <div class="card bg-dark btn-dark w-50 m-2">
            <a href="livros.php" class="btn btn-dark my-2"><img src="../img/search.png" class="img-fluid"  alt="va para Livros">
                <h2>vá para Livros</h2>
            </a>
        </div>
        <div class="w-25">
            <a href="../controller/logout.php" class="btn btn-dark my-2"><img src="../img/exit.jpg" class="img-fluid" alt="va para Chat">
                <h2>SAIR</h2>
            </a>
        </div>        
    </div>
</body>