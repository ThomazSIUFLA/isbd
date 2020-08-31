<?php
include './header.php';
include_once '../controller/emprestimosController.php';
?>
<!doctype html>
<html lang="pt-br">

<head>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <title>Livros</title>
</head>

<body style="background-image: url('../img/fundo.jpg');">
  <span class="d-block p-2 bg-gradient-dark text-info font-weight-bold h2 text-center">EMPRÉSTIMOS
  </span>
  <nav class=" container navbar navbar-expand-md navbar-dark bg-dark">
    <a href="./cadastrarEmprestimo.php" class="btn btn-lg btn-primary m-2" role="button">Criar novo</a>
    <div>

    </div>

    <form class="form-inline my-2 my-lg-0 ml-auto" method="POST" action="">
      <div class="form-group col-md-3 mr-auto">
        <select id="inputState" class="form-control" name="param">
          <option value="nomePessoa">Pesquise por...</option>
          <option value="codEmpr">código Empréstimo</option>
          <option value="nomePessoa">Nome do Aluno</option>
          <option value="situacao">Situação</option>
          <option value="codIsbnLivro">Código Livro</option>
          <option value="tituloLivro">Titulo do Livro</option>
          <option value="dataEmpr">Data Empréstimo</option>
          <option value="dataDevolEmpr">Data Vencimento</option>
          <option value="dataDevolvido">Data Devolução</option>
        </select>
      </div>
      <div id="situacao" class="container col-md-6 ml-auto">
        <div class="form-group ">
          <select id="status" class="form-control" name="status">
            <option value="finalizado">FINALIZADO</option>
            <option value="comAtraso">FINALIZADO COM ATRASO</option>
            <option value="pendente">PENDENTE</option>
            <option value="atrasado">ATRASADO</option>
          </select>
        </div>
      </div>
      <input class="form-control mr-sm-2" type="text" id="pesquisa" name="valor" placeholder="Search" aria-label="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>
    </div>
  </nav>

  <?php

  $valor = isset($_POST) ? $valor = $_POST : null;

  $reg = null;
  $control = new EmprestimoController();
  if (!$valor) {
    $reg = $control->listarEmprestimo();
  } else {
    $reg = $control->pesquisaEmprestimo($valor);
  }
  if ($reg->num_rows > 0) {
  ?>

    <table class="table table-hover container">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Aluno</th>
          <th scope="col">Livro</th>
          <th scope="col">Data do Empréstimo</th>
          <th scope="col">Data Vencimento</th>
          <th scope="col">Data Devolvido</th>
          <th scope="col">SITUAÇÂO</th>
        </tr>
      </thead>
      <tbody class="table-secondary">
        <tr><?php

            while ($registro = $reg->fetch_assoc()) { ?>

        <tr>
          <td>
            <?php echo $registro['codEmpr'] ?>
            <a href="./detalheEmprestimo.php?codEmpr=<?= $registro['codEmpr'] ?>" class="btn btn-sm btn-primary m-2">Ver Detalhes</a>
          </td>

          <td><?php echo $registro['nomePessoa'] ?></td>
          <td>
            <?php
              $livros = $control->listarLivrosEmprestimo($registro['codEmpr']);
            ?>
            <div>
              <?php while ($liv = $livros->fetch_assoc()) { ?>
                <?= $liv['codIsbnLivro'] . '-' . $liv['tituloLivro'] ?><br>
              <?php
              }
              ?>
            </div>
          <td><?php echo date('d/m/Y', strtotime($registro['dataEmpr'])) ?></td>
          <td><?php echo date('d/m/Y', strtotime($registro['dataDevolEmpr'])) ?></td>
          <td>
            <?php if ($registro['dataDevolvido']) {
                echo date('d/m/Y', strtotime($registro['dataDevolvido']));
              } ?></td></area>
          <td class=" font-weight-bold">
            <?php
              if ($registro['dataDevolvido']) {
                if ($registro['dataDevolvido'] <= $registro['dataDevolEmpr']) {
                  echo "<p class='text-success'>FINALIZADO</p>";
                } else {
                  echo "<p class='text-info'>FINALIZADO COM ATRASO</p>";
                }
              } else {
                if ((strtotime($registro['dataDevolEmpr'])) >= strtotime(date('Y-m-d'))) {
                  echo "<p class='text-warning'>PENDENTE</p>";
                } else {
                  echo "<p class='text-danger'>ATRASADO</p>";
                }
                echo "<a href='./finalizarEmprestimo.php?cod=" . $registro['codEmpr'] . "' class='btn btn-sm btn-outline-primary m-2'>finalizar</a>";
                echo "<a href='./renovarEmprestimo.php?cod=" . $registro['codEmpr'] . "' class='btn btn-sm btn-outline-success m-2'>renovar</a>";
              }
            ?>
          </td>
        </tr>
    <?php
            }
          } else {
            echo "<h1>NÂO EXISTE REGISTROS</h1>";
          }

    ?>

      </tbody>
    </table>

    <!-- Optional JavaScript -->
    <script>
      $(document).ready(function() {
        $('#situacao').hide()
        $('#inputState').on('change', function() {
          var selectValor = $(this).val();
          if (selectValor == 'dataEmpr' || selectValor == 'dataDevolEmpr' || selectValor == 'dataDevolvido') {
            $('#pesquisa').prop('type', 'date');
            $('#situacao').hide();
          } else if (selectValor == 'situacao') {
            $('#escolheTurma').hide();
            $('#pesquisa').hide();
            $('#situacao').show();
          } else {
            $('#escolheTurma').hide();
            $('#pesquisa').show();
            $('#situacao').hide();
          }
        });
      });
    </script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
</body>

</html>