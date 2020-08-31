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
  <title>Document</title>
</head>

<body style="background-image: url('../img/quadro.jpg');">
  <span class="d-block p-2 bg-gradient-dark text-info font-weight-bold h2 text-center">Detalhe do Emprestimo</span>
  <?php
  $control = new EmprestimoController();
  $empr = $control->detalharEmprestimo($valor);
  $reg = $empr->fetch_assoc();
  ?>
  <div class="card container center col-md-4" style="background: #007bff linear-gradient(180deg, #268fff, #007bff) repeat-x">
    <img src="../img/Emp.jpg" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title border border-dark bg-white">ALUNO :<?= $reg['nome'] ?>
        <a class="justify-content-end" href="./detalheAluno.php?codaluno=<?= $reg['idUsuario'] ?>">Ver aluno</a>
      </h5>

      <p class="card-text">código Emprestimo: <?php echo $reg['idEmprestimo'] ?></p>
      <h5 class="card-text">Data Empréstimo: <?= date("d/m/Y", strtotime($reg['dataEmprestimo'])) ?></h5>
      <h5 class="card-text">Data Vencimento: <?= date("d/m/Y", strtotime($reg['dataVencimento'])) ?></h5>
      <?php
      if ($reg['dataDevolucao']) {
        if ($reg['dataDevolucao'] <= $reg['dataVencimento']) {
          echo "<p class='text-white font-weight-bold text-center bg-success'>FINALIZADO</p>";
        } else {
          echo "<p class='text-white font-weight-bold text-center bg-success'>FINALIZADO COM ATRASO</p>";
        }
        echo "<h5 class='card-text'>Data Devolução:  " . date("d/m/Y", strtotime($reg['dataDevolucao'])) . "</h5>";
      } else {
        if ((strtotime($reg['dataVencimento'])) >= strtotime(date('Y-m-d'))) {
          echo "<p class='text-wite font-weight-bold text-center bg-warning'>PENDENTE</p>";
        } else {
          echo "<p class='text-white font-weight-bold text-center bg-danger'>ATRASADO</p>";
        }
        echo "<a href='./finalizarEmprestimo.php?cod=" . $valor . "'' class='btn btn-lg btn-success m-2'>finalizar</a>";
        echo "<a href='./finalizarEmprestimo.php?cod=" . $valor . "' class='btn btn-sm btn-secondary m-2'>renovar</a>";
      }
      ?>
    </div>
    <div class="card-body">
      <ul class="list-group list-group-flush">
        <h3>Livros Emprestados</h3>
        <?php
        $livrosEmprestimo =  $control->listarLivrosEmprestimo($reg['idEmprestimo']);
        while ($livro = $livrosEmprestimo->fetch_assoc()) {
        ?>
          <li class="border border-dark bg-white mb-1"><?= $livro['codLivro'] . '-' . $livro['titulo'] ?>
            <a href="./detalheLivro.php?codLivro=<?= $reg['codLivro'] ?>" class='text-right'>Ver livro</a></li>
        <?php
        }
        ?>
      </ul>
    </div>
    <div class="card-body">
      <a href="./excluirEmprestimo.php?cod=<?php echo $reg['idEmprestimo'] ?>" class="card-link btn btn-outline-danger">Excluir</a>
      <a class="card-link btn btn-outline-success" href="./alterarEmprestimo.php?cod=<?php echo $reg['idEmprestimo'] ?>">Alterar</a>
      <input type='button' class="btn btn-success" value='Voltar' onclick='history.back()' />
    </div>
  </div>
</body>

</html>