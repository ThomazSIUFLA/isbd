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

        public function listarAutor($codLivro){
            return $this->cons->listarAutor($codLivro);
        }

        public function detalharLivro ($codLivro){
            
            $res = $this->cons->detalharLivro($codLivro);
            return $res;
        }

        public Function retornaExemplares($cod){

            return $this->cons->retornaExemplares($cod);
        }

        public function verificaDisponibilidade($codExemplar){

            return $this->cons->verificaDisponibilidade($codExemplar);
        }

        public function buscaNomeEditora($codLivro){

            $res = $this->cons->buscaEditora($codLivro);
            $nome = $res->fetch_assoc();
            return $nome['nomeEditora'];
        }

        public function excluirLivro($cod){
            if($this->cons->ExcluiLivro($cod)){
                return "Livro excluido com sucesso!";
            }
            return "falha ao excluir livro";
        }

        public function detalExemplares($codLivro){
            return $this->cons->detalExemplares($codLivro);
        }

        public function alterarLivro($codLivro, $titulo, $cat, $ano, $edicao, $atr, $qtd, $cnpj, $secao, $corr, $prat, $tipoEmp,$autor){
            $this->cons->alterarLivro($codLivro, $titulo, $cat, $ano, $edicao, $atr, $qtd, $cnpj, $secao, $corr, $prat, $tipoEmp,$autor);
        }

    }
