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

<body style="background-image: url('../img/fundo.jpg');">
  <span class="d-block p-2 bg-gradient-dark text-info font-weight-bold h2 text-center">Detalhe do Livro</span>
  <?php
  $control = new LivrosController();
  $liv = $control->detalharLivro($valor);
  $reg = $liv->fetch_assoc();
  $qtd = $control->retornaQtd($valor);
  ?>
  <div class="container card center col-md-8" style="background: #007bff linear-gradient(180deg, #268fff, #007bff) repeat-x">
    <div class="row">
      <img src="../img/logo.png" class="card-img-top w-25" alt="logo">
      <div class="bg-info card col-md-8 p-2 container">
        <h1 class="card-title"><?php echo $reg['tituloLivro'] ?></h1>
        <h3 class="card-title text-warning">código ISBN <?php echo $reg['codIsbnLivro'] ?></h3>
        <?php
        if ($reg['tipoLivro'] == 'L') {
          echo "<p>Estilo:   <strong>" . $reg['estiloLivroLiteratura'] . "</strong></p>";
        } else {
          echo "<p>Disciplina:   <strong>" . $reg['disciplinaLivroDidatico'] . "</strong></p>";
        }
        if ($qtd['qtdDisp'] > 0) {
          echo "<h3 class='text-white bg-success'>Disponível</h3><h2 class='text-white font-weigth-bold'>" . $qtd['qtdDisp'] . "</h2>";
        } else {
          echo "<h3 class='text-white bg-danger'>Indisponível</h3>";
        }
        ?>


      </div>

    </div>
    <div class="card-body">
      <ul class="list-group bg-info">
        <li class="list-group-item bg-info">Editora <?php echo $reg['nomeEditora'] ?></li>
        <li class="list-group-item bg-info">Edição <?php echo $reg['edicaoLivro'] ?></li>
        <li class="list-group-item bg-info">Publicado em <?php echo $reg['anoPublicLivro'] ?></li>
      </ul>
      <ul class="list-group bg-info">
        <li class="list-group-item bg-info">Autores
          <?php
          $aut = $control->listarAutor($reg['codIsbnLivro']);

          if ($aut->num_rows > 0) {
          ?>
            <ul class="list-group bg-info">
              <?php
              while ($autor = $aut->fetch_assoc()) {
              ?>
                <li class="list-group-item bg-info"><?= $autor['nomeAutor'] ?></li>
            <?php
              }
            } else {
              echo "<h3>Não Existe autor cadastrado</h3>";
            }
            ?>
            <h3 class="card-title">Quantidade no acervo:  <?= $qtd['qtdtotal'] ?></h3>
    </div>
    <div class="card-body">
      <a href="./excluirLivro.php?cod=<?php echo $valor ?>" class="card-link btn btn-outline-danger">Excluir</a>
      <a class="card-link btn btn-outline-success" href="./alterarLivro.php?cod=<?= $valor ?>">Alterar</a>
      <input type='button' class="btn btn-success" value='Voltar' onclick='history.back()' />
    </div>
  </div>
</body>

</html>