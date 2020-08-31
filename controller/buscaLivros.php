<?php
include_once './Connection.php';


$palavra = $_POST['busca'];

$query = "SELECT codIsbnLivro,
                 tituloLivro,
                 nomeAutor,
                 anoPublicLivro,
                 edicaoLivro,
                 nomeEditora
          FROM livro NATURAL JOIN
               autorLivro NATURAL JOIN
               editora 
          WHERE tituloLivro LIKE '%$palavra%' OR
                nomeAutor LIKE '%$palavra%' OR
                codIsbnLivro LIKE '%$palavra%' OR
                nomeEditora LIKE '%$palavra%'
          GROUP BY codIsbnLivro";

$connection = new Connection();
$conn = $connection->getConnection();

$res = $conn->query($query);

if($res->num_rows > 0){    
    ?>
    <table class="table table-hover container">
      <thead class="thead-dark">
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
      <tbody class="table-secondary ">
        <tr><?php
    while($row = $res->fetch_assoc()){
        $codLivro = $row['codIsbnLivro'];
        $autor = $row['nomeAutor'];
        $titulo = $row['tituloLivro'];
        $ano = $row['anoPublicLivro'];
        $edicao = $row['edicaoLivro'];
        $editora = $row['nomeEditora'];

        $query2 = "SELECT COUNT(codExemplar) AS qtd
                   FROM exemplar
                   WHERE codIsbnLivro = $codLivro";
        $qtd = $conn->query($query2);
        $qtdTotal = $qtd->fetch_assoc();
        $query2 = "SELECT COUNT(codExemplar) AS qtd
                   FROM exemplar NATURAL JOIN
                        livro NATURAL JOIN
                        emprestimoreferente
                   WHERE codIsbnLivro = $codLivro";
        $qtd = $conn->query($query2);
        $qtdRet = $qtd->fetch_assoc();
        $qtdDisp = $qtdTotal['qtd'] - $qtdRet['qtd'];
        ?>
        <tr>          
          <td><?= $qtdTotal['qtd'] ?></td>
          <td class="font-weight-bold"><?=$qtdDisp?></td>
          <td class="font-weight-bold"><a href="detalheLivro.php?codLivro=<?=$codLivro?>"><?=$codLivro?></a></td>
          <td class="font-weight-bold"><a href="detalheLivro.php?codLivro=<?=$codLivro?>"><?= $titulo?></a></td>
          <td><?= $autor?></td>
          <td><?php echo $ano?></td>
          <td><?php echo $edicao?></td>
          <td><?= $editora ?></td>
        </tr>       
        <?php
    }
} else {
    echo "<h1 class='text-white text-center container bg-dark'>NÃO EXISTE REGISTROS</h1>";
}

?>