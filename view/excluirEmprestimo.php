<?php
include './header.php';
include_once '../Controller/emprestimosController.php';

$param = $_GET;
$chave = key($param);
$valor = $param[$chave];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Empréstimo</title>

</head>

<body style="background-image: url('../img/quadro.jpg');">
    <span class="d-block p-2 bg-gradient-dark text-info font-weight-bold h2 text-center">Exluir Emprestimo</span>
    <?php
    $control = new EmprestimoController();
    $liv = $control->detalharEmprestimo($valor);
    $reg = $liv->fetch_assoc();
    ?>
    <form method="POST">
        <div class="card container center" style="width: 50%;">
            <div class="card-body  bg-danger font-weight-bold">
                <h5 class="card-title h1">Deseja excluir o Emprestimo com código - <?php echo $reg['idEmprestimo'] ?></h5>
                <p class="card-text">Aluno <?php echo $reg['idUsuario'] ?></p>
                <p class="card-text">dataEmpréstimo <?php echo $reg['dataEmprestimo']; ?></p>
            </div>
            <div class="card-body bg-dark" id="op">
                <input type="hidden" value="<?php echo $reg['idEmprestimo']; ?>" name="cod" />
                <input type='button' id="btn" value='Voltar' onclick='history.back()' />
                <button type="submit" class="btn btn-danger justify-content-end" id="btn1">Excluir</a>
            </div>
    </form>

    <?php
    $val = isset($_POST['cod']) ? $valor = $_POST['cod'] : null;

    if ($val != null) {
        $control = new EmprestimoController();

        $res = $control->excluirEmprestimo($reg['idEmprestimo'], $reg['idUsuario']);
    ?>
        <div class="container custom-range::-ms-fill-upper">
            <h1><?php echo $res . " ' " . $reg['nome'] . "'" ?></h1>
            <a class='btn btn-primary btn-lg' href='./Emprestimo.php'>Voltar</a>
        </div>


    <?php

    }

    ?>

    </div>
</body>

</html>