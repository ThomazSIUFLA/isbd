<?php
include './header.php';
include_once '../Controller/livrosController.php';

$param = $_GET;
$chave = key($param);
$valor = $param[$chave];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body style="background-image: url('../img/quadro.jpg');">
    <span class="d-block p-2 bg-gradient-dark text-info font-weight-bold h2 text-center">Exluir Livro</span>
    <?php
    $control = new LivrosController();
    $liv = $control->detalharLivro($valor);
    $reg = $liv->fetch_assoc();
    ?>
    <form method="POST">
        <div class="card container center" style="width: 50%;">
            <div class="card-body  bg-danger font-weight-bold">
                <h5 class="card-title h1">Deseja excluir o livro <?php echo $reg['tituloLivro'] ?></h5>
                <p class="card-text">código ISBN <?php echo $reg['codIsbnLivro'] ?></p>
            </div>
            <div class="card-body bg-dark" id="op">
                <input type="text" name="cod" id="" value="<?= $valor ?>" hidden>
                <input type='button' id="btn" value='Voltar' onclick='history.go(-2)' />
                <?php
                $qtd = $control->retornaQtd($valor);
                if($qtd['qtdtotal'] == $qtd['qtdDisp']){
                ?>
                <button type="submit" class="btn btn-danger justify-content-end" id="btn1">Excluir</a>
                <?php
                }
                else {
                    echo "<h4 class='card-title h1'>Não pode ser excluído</h4>";
                    echo "<h6 class='card-title h1'>Existem exemplares emprestados</h6>";
                }
                ?>
            </div>
            
    </form>

    <?php
    $val = isset($_POST['cod']) ? $valor = $_POST['cod'] : null;

    if ($val != null) {
        $control = new LivrosController();
        $res = $control->excluirLivro($reg['codIsbnLivro']);
    ?>
        <div class="container custom-range::-ms-fill-upper">
            <h1><?php echo $res . " ' " . $reg['tituloLivro'] . "'" ?></h1>
            <a class='btn btn-primary btn-lg' href='./livros.php'>Voltar</a>
        </div>

    <?php

    }

    ?>

    </div>
</body>

</html>