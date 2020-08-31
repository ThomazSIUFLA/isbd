<?php
    include '../controller/Connection.php';
    include '../controller/consultas.php';
    
    class LivrosController{
        protected $conn;
        protected $cons;
        
        public function __construct(){
            $connection = new Connection();
            $this->conn = $connection->getConnection();
            $this->cons = new Consultas($this->conn);
        }

        public function listarLivros(){
            $res = $this->cons->listarLivros($this->conn);
            
            return $res;   
        }

        public function retornaQtd($codLivro){
            $res = $this->cons->retornaQtd($codLivro);
            return $res;
        }
        public function cadastrarEditora($cnpj, $nome, $site, $tel, $email, $logr, $num, $comp, $bairro, $cidade, $cep, $unid){
            $this->cons->cadastrarEditora($cnpj, $nome, $site, $tel, $email, $logr, $num, $comp, $bairro, $cidade, $cep, $unid);
        }

        public function listarEditoras(){
            $res = $this->cons->listarEditoras();
            return $res;
        }

        public function cadastrarLivro($codLivro, $titulo, $cat, $ano, $edicao, $atr, $qtd, $cnpj, $secao, $corr, $prat, $tipoEmp,$autor){
            $this->cons->cadastrarLivro($codLivro, $titulo, $cat, $ano, $edicao, $atr, $qtd, $cnpj, $secao, $corr, $prat, $tipoEmp,$autor);
        }

        public function listarAutor(){
            $res = $this->cons->listarAutor();
        }

        public function buscaNomeEditora($codLivro){
            $connection = new Connection();
            $conn = $connection->getConnection();   
            $dao = new LivroDao();
            $res = $dao->buscaEditora($conn, $codLivro);
            $nome = $res->fetch_assoc();
            return $nome['nomeEditora'];
        }

        public function buscaDisponiveis($codLivro){
            $connection = new Connection();
            $conn = $connection->getConnection();   
            $dao = new LivroDao();            
            $res = $dao->buscaDisponiveis($conn, $codLivro);
            $disp = $res->fetch_assoc();
            return $disp['quant'];
        }

        public function detalharLivro ($codLivro){
            $connection = new Connection();
            $conn = $connection->getConnection();   
            $dao = new LivroDao();
            $res = $dao->detalharLivro($conn, $codLivro);
            return $res;
        }

        public function pesquisaLivro($valor){
            $connection = new Connection();
            $conn = $connection->getConnection();   
            $dao = new LivroDao();
            
            $res = $dao->pesquisaLivro($conn,$valor['param'],$valor['valor']);
            
            return $res;
        }

        public function excluirLivro($cod){
            $connection = new Connection();
            $conn = $connection->getConnection();   
            $dao = new LivroDao();
            if($dao->ExcluiLivro($conn,$cod)){
                return "Livro excluido com sucesso!";
            }
            return "falha ao excluir livro";
        }

    }
