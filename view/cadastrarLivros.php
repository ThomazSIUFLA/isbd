<?php
include './header.php';
//include './footer.html';
include_once '../Controller/livrosController.php';
?>
<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <title>Cadastro de livros</title>
</head>

<body style="background-image: url('../img/fundo.jpg');">
    <span class="d-block p-2 bg-gradient-dark text-info font-weight-bold h2 text-center">Cadastrar novo livro</span>

    <div class="card container">
        <form method="POST" action="" class="container" style="width:100%; height: 400px; overflow: auto;">
            <label for="editora">Selecione a editora</label>
            <div class="form-group row">

                <select id="editora" class="form-control col-md-4 mb-3 ml-2" name="edit" required>
                    <option value="">Selecione...</option>
                    <option value="nova">Cadastrar Nova</option>
                    <?php
                    $control = new LivrosController();
                    $res = $control->listarEditoras();
                    while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                        <option value="<?= $row['cnpj'] ?>"><?= $row['cnpj'] . " - " . $row['nome'] ?></option>
                    <?php } ?>

                </select>
            </div>
            <div class="formulario card bg-secondary" id="cadEditora">
                <div class="form col-md-12 row form-group">
                    <label for="cnpj">CNPJ</label>
                    <input type="text" class="form-control col-md-3" name="cnpj" id="edcnpj" placeholder="Digite o cnpj da editora">
                    <label for="exampleInputEmail1">Nome</label>
                    <input type="text" class="form-control col 6" name="nomeEdit" id="ednome" placeholder="Digite o nome da editora">
                    <label for="exampleInputEmail1">Site</label>
                    <input type="text" class="form-control col-3" name="siteEdit" id="edsite" placeholder="Digite o site da editora">
                </div>
                <div class="row form-group col-12">
                    <label for="cnpj">Telefone</label>
                    <input type="text" class="form-control col-4" name="telEdit" id="edtel" placeholder="Digite o telefone da editora">
                    <label for="exampleInputEmail1">E-mail</label>
                    <input type="email" class="form-control col-6" name="emailEdit" id="edemail" placeholder="Digite o e-mail da editora">
                </div>
                <h5>Endereço</h5><br>
                <div class="row form-group col-12">
                    Rua
                    <input type="text" class="form-control col-5" name="logEdit" id="edlog" placeholder="Rua/Av/Tv etc.">
                    <label for="exampleInputEmail1">Nº</label>
                    <input type="number" class="form-control col 1" name="numEdit" id="ednum" placeholder="Nº">
                    <label for="exampleInputEmail1">Complemento</label>
                    <input type="text" class="form-control col 1" name="complEdit" placeholder="complemento">
                    <label for="exampleInputEmail1">Bairro</label>
                    <input type="text" class="form-control col-3" name="bairroEdit" id="edbairro" placeholder="Bairro">
                </div>
                <div class="row form-group col-12">
                    Cidade
                    <input type="text" class="form-control col-5" name="cidadeEdit" id="edcidade" placeholder="cidade">
                    <label for="exampleInputEmail1">CEP</label>
                    <input type="text" class="form-control col 1" name="cepEdit" id="edcep" placeholder="CEP">
                    <label for="exampleInputEmail1">Unidade</label>
                    <input type="text" class="form-control col-3" name="unidEdit" id="edunid" placeholder="unid">
                </div>
            </div>
            <div class="form-group formulario row">
                <label for="exampleInputEmail1">Título do Livro</label>
                <input type="text" class="form-control col-6" name="titulo" placeholder="Digite o nome do livro" required>
                <label for="exampleInputEmail1">Categoria do Livro</label>
                <select name="cat" id="cat" class="col-2 form-control">
                    <option value="L">Literatura</option>
                    <option value="D">Didático</option>
                </select>
            </div>
            <div class="row">
                <label for="exampleInputEmail1">Ano de publicação</label>
                <input type="number" max-lenght="4" name="anoPublic" min="1900" max="2030" class="col-1 mb-3 form-control" required>
                <label for="exampleInputEmail1">Edição</label>
                <input type="number" name="edicao" class="col-1 mb-4 form-control" required>
                <label for="exampleInputEmail1" id="disc">Estilo</label>
                <input type="text" name="disc" class="col-1 mb-4 form-control" required>
            </div>
            <div class="row">
                <label for="exampleInputEmail1">isbn</label>
                <input type="text" max-lenght="13" name="isbn" class="col-3 mb-3 form-control" placeholder="Digite o código ISBN" required>
                <label for="exampleInputEmail1">Quantidade de exemplares</label>
                <input type="number" max-lenght="13" name="quantidade" class="col-md-2 mb-3 form-control" placeholder="Digite a quantidade" required>
                <label for="autor">Autor</label>
                <input type="text" class="form-control col-3" name="autor" placeholder="Digite o nome do autor">
            </div>
            <div class="row col-12">
                <label for="exampleInputEmail1">Localização</label>
                <div class="col-1">
                    <label for="exampleInputEmail1">Seção</label>
                    <input type="number" max-lenght="13" name="secao" class="mb-3 form-control" required>
                </div>
                <div class="col-1">
                    <label for="exampleInputEmail1">Corredor</label>
                    <input type="number" max-lenght="13" name="corr" class="mb-3 form-control" required>
                </div>
                <div class="col-1">
                    <label for="exampleInputEmail1">Prateleira</label>
                    <input type="number" max-lenght="13" name="prat" class="mb-3 form-control" required>
                </div>
                <div class="col-4 ml-2">
                    <label for="exampleInputEmail1">Tipo de Empréstimo</label>
                    <div>
                        <input type="radio" class id="an" name="tipoEmp" value="A">
                        <label for="an">Anual</label><br>
                        <input type="radio" id="ms" name="tipoEmp" value="M">
                        <label for="ms">Mensal</label><br>
                        <input type="radio" id="sm" name="tipoEmp" value="S">
                        <label for="sm">Semanal</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-outline-primary ml-1">Limpar</button>
                <a href="./livros.php" class="btn btn-secondary ml-1">Voltar</a>
                <button type="submit" class="btn btn-primary btn-lg ml-1" id="btn" style="width: 300px; height: 40px;">Salvar</button>
            </div>

        </form>
    </div>


    <!-- Optional JavaScript -->
    <script>
        $(document).ready(function() {
            $('#cadEditora').hide();
            $('#editora').on('change', function() {
                var selectValor = $(this).val();
                if (selectValor == 'nova') {
                    $('#cadEditora').show();
                    $("#edcnpj").attr("required", "req");
                    $("#ednome").attr("required", "req");
                    $("#edsite").attr("required", "req");
                    $("#edtel").attr("required", "req");
                    $("#edemail").attr("required", "req");
                    $("#edlog").attr("required", "req");
                    $("#ednum").attr("required", "req");
                    $("#edbairro").attr("required", "req");
                    $("#edcidade").attr("required", "req");
                    $("#edunid").attr("required", "req");
                    $("#edcep").attr("required", "req");
                } else {
                    $('#cadEditora').hide();
                }
            });
            $('#cat').on('change', function() {
                var cat = $(this).val();
                if (cat == 'L') {
                    $('#disc').text('Estilo')
                } else if (cat == 'D') {
                    $('#disc').text('Disciplina')
                }
            });
        });
    </script>
</body>

</html>

<?php
if ($_POST) {
    $cnpj = $_POST['edit'];
    if ($_POST['cnpj'] != "") {
        $cnpj = $_POST['cnpj'];
        $nome = $_POST['nomeEdit'];
        $site = $_POST['siteEdit'];
        $tel = $_POST['telEdit'];
        $email = $_POST['emailEdit'];
        $logr = $_POST['logEdit'];
        $num = $_POST['numEdit'];
        $comp = $_POST['complEdit'];
        $bairro = $_POST['bairroEdit'];
        $cidade = $_POST['cidadeEdit'];
        $cep = $_POST['cepEdit'];
        $unid = $_POST['unidEdit'];

        $control->cadastrarEditora($cnpj, $nome, $site, $tel, $email, $logr, $num, $comp, $bairro, $cidade, $cep, $unid);
    }
    $codLivro = $_POST['isbn'];
    $titulo = $_POST['titulo'];
    $cat =  $_POST['cat'];
    $ano =  $_POST['anoPublic'];
    $edicao =  $_POST['edicao'];
    $atr =  $_POST['disc'];
    $qtd =  $_POST['quantidade'];
    $secao = $_POST['secao'];
    $corr = $_POST['corr'];
    $prat = $_POST['prat'];
    $tipoEmp = $_POST['tipoEmp'];
    $autor = $_POST['autor'];

    $control->cadastrarLivro($codLivro, $titulo, $cat, $ano, $edicao, $atr, $qtd, $cnpj, $secao, $corr, $prat, $tipoEmp,$autor);
?><script>
        if (confirm("SUCESSO,    Deseja cadastrar outro livro?")) {
            alert('entre com os dados');
        } else {
            window.location.href = "./livros.php";
        }
    </script>
<?php
}
?>