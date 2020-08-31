<?php
include './header.php';
include_once '../Controller/emprestimosController.php';

if (!isset($_SESSION)) {
    session_start();
}

$bibliotecario = $_SESSION['usuario'];
$idBibliotecario = $_SESSION['codPessoa'];

$control = new EmprestimoController();

?>
<!doctype html>
<html lang="pt-br">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <title>Emprestimos</title>

</head>

<body style="background-image: url('../img/fundo.jpg');">
    <span class="d-block p-2 bg-gradient-dark text-info font-weight-bold h2 text-center">CADASTRAR EMPRÉSTIMO
    </span>

    <div class="card w-75 container">
        <div class="card-body">
            <h3 class="card-title text-center">Cadastrar novo Empréstimo</h3>
            <form action="" class="" method="post">
                <div class="form-group table-primary row container">
                    <div class="col-md-3">
                        <label for="exampleInputEmail1">código do Aluno</label>
                        <input type="text" class="form-control" id="campoNome" name="nomePessoa" placeholder="digite o nome">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1">nome do Aluno</label>
                        <input type="text" class="form-control" id="pesquisaAluno" name="nomePessoa" placeholder="digite o nome" required>

                    </div>
                    <div class="col-md-8">
                        <label for="exampleInputEmail1">Código dos livros, separados por vírgula</label>
                        <input type="text" class="form-control" id="campoLivros" name="livros" placeholder="EX:12,25,45" required>
                        <a onclick="javascript: window.open('./livros.php', 'janela1', 'width=1000, height=300, top=0, left=300');" class="btn btn-outline-info"> pesquisar Livro</a>
                    </div>
                </div>
                <label for="data">Escolha a data para devolução</label>
                <div>
                    <input type="radio" class="radio" name="tempo" value="10">
                    <label for="10">Daqui 10 dias</label><br>
                    <input type="radio" class="radio" name="tempo" value="15">
                    <label for="15">Daqui 15 dias</label><br>
                    <input type="radio" class="radio" name="tempo" value="30">
                    <label for="30">Daqui 1 mês</label><br>
                    <input type="radio" class="radio" name="tempo" value="1">
                    <label for="escolher">escolher outra data</label>
                </div>
                <div id="calendar">
                    <input type="date" name="data" value="<?php echo date('Y-m-d'); ?>" min="<?= date('Y-m-d') ?>">
                </div>
                <button type="submit" class="btn btn-success justify-contents-end" style="float: right; width: 300px; height: 40px;" value="continuar" id="btn">CONTINUAR
                </button>
            </form>
        </div>
    </div>



    <!-- Optional JavaScript -->
    <script src="../js/scriptCadastrarEmprestimo.js"></script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
</body>

</html>

<?php
if ($_POST) {
    $codAluno = $_POST['idUsuario'];
    $dataVencimento = $_POST['data'];
    $livros = $_POST['livros'];
    if ($_POST['tempo']) {
        $dataVencimento = date('Y-m-d', strtotime('+' . $_POST['tempo'] . 'days'));
    }
    $control = new EmprestimoController();
    $control->cadastrarEmprestimo($idBibliotecario, $codAluno, $livros, $dataVencimento);
    ?>
    <script>
      if (confirm("Deseja cadastrar outro empréstimo?")) {
        alert('entre com os dados');
      } else {
        window.location.href = "./emprestimos.php";
      }
    </script>
    <?php
}
?>