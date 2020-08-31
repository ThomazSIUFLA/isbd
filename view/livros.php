<?php
include_once '../controller/livrosController.php';
include './header.php';
?>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->

  <title>Biblio.tech</title>
</head>

<body style="background-image: url('../img/fundo.jpg');">
  <span class="d-block bg-gradient-dark text-info font-weight-bold h2 text-center">LIVROS
  </span>
  <nav class=" container navbar navbar-expand-md navbar-dark bg-silver">
    <a href="cadastrarLivros.php" class="btn btn-lg btn-primary" role="button">Cadastrar novo</a>
    <form class="form-inline my-2 col-8 my-lg-0 ml-auto">
      <input class="form-control mr-2 col-8" type="text" id="busca" name="valor" placeholder="Search" aria-label="Search" autocomplete="false">
    </form>
  </nav>
  <?php
  $control = new LivrosController();
  $res = $control->listarLivros();
  if($res->num_rows > 0){    
    ?>
    <div id="tabela" class="container" >
    <table class="table table-hover ">
      <thead class="thead thead-dark">
        <tr>
          <th scope="col">quant Total</th>
          <th scope="col">disponível</th>
          <th scope="col">Código</th>
          <th scope="col">Título</th>
          <th scope="col">Autor</th>
          <th scope="col">Ano Public.</th>
          <th scope="col">Edição</th>
          <th scope="col">Editora</th>
        </tr>
      </thead>
      <tbody class="table-secondary">
        <?php
    while($row = $res->fetch_assoc()){
        $codLivro = $row['codIsbnLivro'];
        $autor = $row['nomeAutor'];
        $titulo = $row['tituloLivro'];
        $ano = $row['anoPublicLivro'];
        $edicao = $row['edicaoLivro'];
        $editora = $row['nomeEditora'];

        $qtds = $control->retornaQtd($codLivro);
        $total = $qtds['qtdtotal'];
        $disp = $qtds['qtdDisp'];
 
        ?>
        <tr>          
          <td><?= $total?></td>
          <td class="font-weight-bold"><?=$disp?></td>
          <td class="font-weight-bold"><a href="detalheLivro.php?codLivro=<?=$codLivro?>"><?=$codLivro?></a></td>
          <td class="font-weight-bold"><a href="detalheLivro.php?codLivro=<?=$codLivro?>"><?= $titulo?></a></td>
          <td><?= $autor?></td>
          <td><?php echo $ano?></td>
          <td><?php echo $edicao?></td>
          <td><?= $editora ?></td>
        </tr>
        
        <?php
            }
          } 
          ?>
      </tbody>
    </table>
    </div>
  <p id="resultado"></p>
    <script>
      $("#busca").keyup(function(){
        var valor = $(this).val();
        if(valor){
          $('#tabela').hide();
        }
        var busca = $('#busca').val();
        $.post('../controller/buscaLivros.php', {busca: busca}, function(data){
          $('#resultado').html(data);
        });
      });
    </script>
</body>

</html>
