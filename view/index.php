<?php
include './header.php';
include './footer.html';

?>

<body style="background-image: url('../img/fundo.jpg');">

    <span class="d-block p-2 bg-gradient-dark text-info font-weight-bold h2 text-center">HOME</span>

    <div class="card-deck container m-auto w-75">
        <div class="card bg-dark btn-dark w-25 m-2">
            <a href="emprestimos.php" class="btn btn-dark my-2"><img src="../img/emp.jpg" class="img-fluid" alt="va para editoras">
                <h2>vá para Empréstimos</h2>
            </a>
        </div>
        <div class="card bg-dark btn-dark w-25 m-2">
            <a href="livros.php" class="btn btn-dark my-2"><img src="../img/livros.jpg" class="img-fluid"  alt="va para Livros">
                <h2>vá para Livros</h2>
            </a>
        </div>
        <div class="card bg-dark btn-dark w-25 m-2">
            <a href="alunos.php" class="btn btn-dark my-2"><img src="../img/alunos.jpg" class="img-fluid" alt="va para Livros">
                <h2>vá para Alunos</h2>
            </a>
        </div>
    </div>
    <div class="card-deck container m-auto w-75">
        <div class="card bg-dark btn-dark w-25 m-2">
            <a href="editoras.php" class="btn btn-dark my-2"><img src="../img/editora.jpg" class="img-fluid" alt="va para editoras">
                <h2>vá para editoras</h2>
            </a>
        </div>

        <div class="card bg-dark btn-dark w-25 m-2">
            <a href="livros.php" class="btn btn-dark my-2"><img src="../img/estat.jpg" class="img-fluid" alt="va para estatísticas">
                <h2>vá para Estatísticas</h2>
            </a>
        </div>
        <div class="card bg-dark btn-dark w-25 m-2">
            <a href="livros.php" class="btn btn-dark my-2"><img src="../img/chat.jpg" class="img-fluid" alt="va para Chat">
                <h2>vá para o Chat</h2>
            </a>
        </div>
    </div>
</body>