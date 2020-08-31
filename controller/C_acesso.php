<?php
session_start();
include_once './Connection.php';
include_once './consultas.php';
$usuario = $_POST['usuario'];

$conn = new Connection();
$conn = $conn->getConnection();

$dao = new Consultas($conn);
$res = $dao->logar($usuario);


$mensagem = "ok";
if(!$res){
    $mensagem = "Usuário ou Senha INCORRETO";  
} else {
    $res;
    $_SESSION['usuario'] = $res['nomePessoa'];
    $_SESSION['codPessoa'] = $res['codPessoa'];
    $conn->close();
    header('location: ../view/index.php');
}
erro($mensagem);

function erro($mensagem){
    echo "
    <style>
    .btn-info {
        color: #fff;
        font-size: 2.0rem;
        background: #17a2b8 linear-gradient(180deg, #3ab0c3, #17a2b8) repeat-x;
        border-color: #17a2b8;
        width: 150px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075);
      }
      .btn-info:hover {
        color: #fff;
        background: #138496 linear-gradient(180deg, #3696a6, #138496) repeat-x;
        border-color: #117a8b;
      }
      .btn-info:focus, .btn-info.focus {
        color: #fff;
        background: #138496 linear-gradient(180deg, #3696a6, #138496) repeat-x;
        border-color: #117a8b;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 0 0.2rem rgba(58, 176, 195, 0.5);
      }
    </style>
    <h1 style='color: red; font-size: 2.0rem; background-color: grey'>$mensagem</h1>
    <input type='button' class='btn-info' value='Voltar' onClick='history.go(-1)'>
    ";
}



?>