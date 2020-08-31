<?php

class Consultas {
    protected $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function logar($email){
        $query = "SELECT codPessoa, nomePessoa
        FROM pessoa
        WHERE emailPessoa = '$email';";

        $id = $this->conn->query($query);
        if($id){
            $res = $id->fetch_assoc();     
            return $res;
        }
    }

    public function listarEmprestimos () {
        $query = "SELECT * 
        FROM emprestimo INNER JOIN 
             pessoa
        WHERE pessoa.codPessoa = emprestimo.codPessoaRealiza
        GROUP BY codEmpr
        ORDER BY dataEmpr DESC;";

        $res = $this->conn->query($query);
        return $res;
    }

    public function listarLivrosEmprestimo($codEmprestimo){
        $query = "SELECT codIsbnLivro, 
                         codExemplar,
                         tituloLivro 
        FROM livro NATURAL JOIN 
             exemplar NATURAL JOIN 
             emprestimoreferente
        WHERE codEmpr = $codEmprestimo";

        $res = $this->conn->query($query);
        return $res;
    }

    public function pesquisaEmprestimo($param,$valor){
        $query = 'SELECT * 
                  FROM emprestimo INNER JOIN 
                       pessoa
                  WHERE';
        if ($valor == 'finalizado'){
            $query = $query." dataDevolvido <= dataDevolEmpr";
        } elseif ($valor == 'comAtraso'){
            $query = $query." dataDevolvido > dataDevolEmpr";            
        } elseif ($valor == 'pendente'){
            $hoje = date("Y-m-d");
            $query = $query." dataDevolEmpr >= '$hoje'";
        } elseif ($valor == 'atrasado'){
            $hoje = date("Y-m-d");
            $query = $query." dataDevolvido IS NULL AND dataDevolEmpr < '$hoje'";
        }  else {
            $query = $query." $param LIKE '%$valor%'";
        }

        $query = $query." AND pessoa.codPessoa = emprestimo.codPessoaRealiza ORDER BY nomePessoa;";

        $res = $this->conn->query($query);
        return $res;
    }

    public function CadastrarEmprestimo($bibl, $aluno, $dataDevolucao,$livrosArray){
        $hoje = date("Y-m-d");
        $query = "INSERT INTO emprestimo(dataEmpr, 
                                         dataDevolEmpr, 
                                         codPessoaRealiza, 
                                         codFunc) 
                VALUES (NOW(), $dataDevolucao, $aluno, $bibl)";
        //$this->conn->query($query);
        $idEmp = mysqli_insert_id($this->conn);
        
        foreach ($livrosArray as $livro){
            $query2 = "SELECT codExemplar
                       FROM exemplar NATURAL JOIN livro
                       WHERE codIsbnLivro = $livro";
                       echo $query2;
            //$this->conn->query("INSERT INTO emprestimoreferente(codExemplar, codEmpr) 
                                //VALUES ($idEmp,$livro)");
        }        
    }

    public function listarLivros ($conn) {
        $query = "SELECT codIsbnLivro,
                 tituloLivro,
                 nomeAutor,
                 anoPublicLivro,
                 edicaoLivro,
                 nomeEditora
          FROM livro NATURAL JOIN
               autorLivro NATURAL JOIN
               editora
          WHERE 1
          GROUP BY codIsbnLivro
          ORDER BY tituloLivro";
        $res = $conn->query($query);
        return $res;
    }

    public function retornaQtd($codLivro){
        $query = "SELECT COUNT(codExemplar) AS qtd
                   FROM exemplar
                   WHERE codIsbnLivro = $codLivro";
        $qtd = $this->conn->query($query);
        $qtdTotal = $qtd->fetch_assoc();
        $res['qtdtotal'] = $qtdTotal['qtd'];
        $query = "SELECT COUNT(codExemplar) AS qtd
                   FROM exemplar NATURAL JOIN
                        livro NATURAL JOIN
                        emprestimoreferente
                   WHERE codIsbnLivro = $codLivro";
        $qtd = $this->conn->query($query);
        $qtdRet = $qtd->fetch_assoc();
        $res['qtdDisp'] = $qtdTotal['qtd'] - $qtdRet['qtd'];

        return $res;
    }

    public function listarEditoras(){
        $query = "SELECT nomeEditora AS nome,
                         cnpjEditora AS cnpj
                FROM editora";
        $res = $this->conn->query($query);
        return $res;
    }

    public function cadastrarEditora($cnpj, $nome, $site, $tel, $email, $logr, $num, $comp, $bairro, $cidade, $cep, $unid){
        $query = "INSERT INTO editora(cnpjEditora, 
                              nomeEditora, 
                              emailEditora, 
                              siteEditora) 
        VALUES ('$cnpj','$nome','$email','$site')";
        $this->conn->query($query);
        $query = "INSERT INTO enderecoeditora(cnpjEditora, 
                                              unidadeEditora, 
                                              logradouroEditora, 
                                              numeroEditora, 
                                              complementoEditora, 
                                              bairroEditora, 
                                              cidadeEditora, 
                                              cepEditora) 
        VALUES ('$cnpj', '$unid', '$logr', $num, '$comp', '$bairro', '$cidade', '$cep')";
        $this->conn->query($query);
        $query = "INSERT INTO telefoneeditora(cnpjEditora, numTelefone) VALUES ('$cnpj', '$tel')"; 
        $this->conn->query($query);       
    }

    public function cadastrarLivro($codLivro, $titulo, $cat, $ano, $edicao, $atr, $qtd, $cnpj, $secao, $corr, $prat, $tipoEmp,$autor){
        if($cat == 'L'){
            $tipo = "estiloLivroLiteratura";
        } else {
            $tipo = "disciplinaLivroDidatico";
        }
        $query = "INSERT INTO livro(
            codIsbnLivro, 
            tituloLivro, 
            anoPublicLivro, 
            edicaoLivro, 
            tipoLivro, 
            $tipo, 
            cnpjEditora) 
        VALUES (
            '$codLivro',
            '$titulo',
            '$ano',
            '$edicao',
            '$cat',
            '$atr',
            '$cnpj')";
        $codExemp = 0;
        $this->conn->query($query);
        $codExemp = 0;
        $resCodExe = $this->conn->query("SELECT MAX(codExemplar) AS cod FROM exemplar WHERE codIsbnLivro = $codLivro");
        if($resCodExe){
            $codExemp = $resCodExe->fetch_assoc();
        }
        for($i=1; $i <= $qtd; $i++){
            $cod = (int)$codExemp + $i;
            $codExemplar = $codLivro."_".$cod;
            $ex = "INSERT INTO exemplar(
                codExemplar, 
                tipoEmprestimo, 
                secaoLocalExemplar, 
                corredorLocalExemplar, 
                prateleiraLocalExemplar, 
                codIsbnLivro) 
            VALUES ($codExemplar, '$tipoEmp', $secao, $corr, $prat, '$codLivro')";
            $this->conn->query($ex);
        }
        $query = "INSERT INTO autorlivro(codIsbnLivro, nomeAutor) VALUES ($codLivro,$autor)";        
    }

    public function listarAutor(){
        $query = "SELECT nomeAutor FROM autorLivro";
        $res = $this->conn->query($query);
    }
}
?>