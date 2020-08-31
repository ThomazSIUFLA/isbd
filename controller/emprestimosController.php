<?php
    include '../controller/Connection.php';
    include '../controller/consultas.php';
    
    class EmprestimoController{
        protected $conn;
        protected $cons;
        
        public function __construct(){
            $connection = new Connection();
            $this->conn = $connection->getConnection();
            $this->cons = new Consultas($this->conn);
        }

        public function listarEmprestimo(){
            $res = $this->cons->listarEmprestimos();
            return $res;            
        }

        public function listarLivrosEmprestimo($codEmprestimo){
            $res = $this->cons->listarLivrosEmprestimo($codEmprestimo);
            return $res;
        }

        public function pesquisaEmprestimo($valor){

            $param = $valor['param'];

            if ($param == 'situacao') {
                $val = $valor['status'];
            }else{
                $val = $valor['valor'];
            }
            
            $res = $this->cons->pesquisaEmprestimo($param,$val);
            return $res;
        }

        public function cadastrarEmprestimo($bibl, $aluno, $livros, $dataDevolucao){
            $livrosArray = explode(",", $livros);      
            $res = $this->cons->CadastrarEmprestimo($bibl, $aluno, $dataDevolucao,$livrosArray);

        }


        /*public function cadastrarEmprestimo($bibl, $aluno, $livros, $dataDevolucao){
            $livrosArray = explode(",", $livros);      

            $connection = new Connection();
            $conn = $connection->getConnection();
            $cons = new Consultas($conn);
            $res = $cons->CadastrarEmprestimo($conn, $bibl, $aluno, $dataDevolucao,$livrosArray);

        }

        public function alterarEmprestimo($novoidEmprestimo, $novaDataVencimento, $novaDataEmprestimo, $novoLivros){
            $connection = new Connection();
            $conn = $connection->getConnection();
            $cons = new Emprestimocons$cons();
            $dataEmp = date("Y-m-d", strtotime($novaDataEmprestimo));
            $dataVenc = date("Y-m-d", strtotime($novaDataVencimento));
            $cons->alterarEmprestimo($conn, $novoidEmprestimo, $dataVenc, $dataEmp , $novoLivros);
        }

        public function listar(){
            $connection = new Connection();
            $conn = $connection->getConnection();
            $cons = new Emprestimocons$cons();
            $res = $cons->listarEmprestimos($conn);
            return $res;
            
        }

        public function listarLivrosEmprestimo($codEmprestimo){
            $connection = new Connection();
            $conn = $connection->getConnection();
            $cons = new Emprestimocons$cons();
            $res = $cons->listarLivrosEmprestimo($conn, $codEmprestimo);
            return $res;
        }

        public function listarCodigosLivrosEmprestimo($codEmprestimo){
            $connection = new Connection();
            $conn = $connection->getConnection();
            $cons = new Emprestimocons$cons();
            $res = $cons->listarCodigosLivrosEmprestimo($conn, $codEmprestimo);
            return $res;
        }

        public function detalharEmprestimo ($codEmprestimo){
            $connection = new Connection();
            $conn = $connection->getConnection();   
            $cons = new Emprestimocons$cons();
            $res = $cons->detalharEmprestimo($conn, $codEmprestimo);
            
            return $res;
        }

        public function pesquisaEmprestimo($valor){
            $connection = new Connection();
            $conn = $connection->getConnection();   
            $cons = new Emprestimocons$cons();

            $param = $valor['param'];

            if($param == 'turma'){
                $val = $valor['serie'].'-'.$valor['turma'];
            } elseif ($param == 'situacao') {
                $val = $valor['status'];
            }else{
                $val = $valor['valor'];
            }
            
            $res = $cons->pesquisaEmprestimo($conn,$param,$val);
            return $res;
        }

        public function finalizaEmprestimo($codEmprestimo){
            $connection = new Connection();
            $conn = $connection->getConnection();   
            $cons = new Emprestimocons$cons();
           
            $cons->finalizaEmprestimo($conn,$codEmprestimo);            
        }

        public function listarTurmas(){
            $connection = new Connection();
            $conn = $connection->getConnection();   
            $cons = new Emprestimocons$cons();

            $res = $cons->listarTurmas($conn);
            return $res;
        }

        public function listarAlunos($turma){
            $connection = new Connection();
            $conn = $connection->getConnection();   
            $cons = new Emprestimocons$cons();

            $res = $cons->listarAlunos($conn, $turma);
            return $res;
        }

        public function renovaEmprestimo($codEmprestimo, $dados){
            $connection = new Connection();
            $conn = $connection->getConnection();   
            $cons = new Emprestimocons$cons();

            $novaData = $dados['data'];
            $dias = $dados['tempo'];
            if($dias != 0){
                $novaData = date('Y-m-d', strtotime("+$dias days"));
            }
            $cons->renovaEmprestimo($conn,$codEmprestimo, $novaData);            
        }

        public function excluirEmprestimo($idEmprestimo, $idUsuario){
            $connection = new Connection();
            $conn = $connection->getConnection();   
            $cons = new Emprestimocons$cons();
            if($cons->ExcluiEmprestimo($conn,$idEmprestimo, $idUsuario)){
                return "Emprestimo excluido com sucesso!";
            }
            return "falha ao excluir Emprestimo";
        }*/

    }
