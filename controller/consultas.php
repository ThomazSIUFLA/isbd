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
        $query = "SELECT 
                 L.codIsbnLivro,
                 L.tituloLivro,
                 A.nomeAutor,
                 L.anoPublicLivro,
                 L.edicaoLivro,
                 E.nomeEditora
          FROM livro L NATURAL JOIN
               editora E LEFT OUTER JOIN
               autorLivro A 
          ON A.codIsbnLivro = L.codIsbnLivro
          GROUP BY L.codIsbnLivro
          ORDER BY L.tituloLivro";
        $res = $conn->query($query);
        return $res;
    }

    public function retornaQtd($codLivro){
        $query = "SELECT COUNT(codExemplar) AS qtd
                   FROM exemplar
                   WHERE codIsbnLivro = $codLivro";
        $qtd = $this->conn->query($query);
        $qtdTotal = $qtd->fetch_assoc();
        $qtd = null;
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

    public function alterarLivro($codLivro, $titulo, $cat, $ano, $edicao, $atr, $qtd, $cnpj, $secao, $corr, $prat, $tipoEmp,$autor){
        if($cat == 'L'){
            $tipo = "estiloLivroLiteratura";
        } else {
            $tipo = "disciplinaLivroDidatico";
        }
        $query = "UPDATE livro
            SET codIsbnLivro = '$codLivro',
            tituloLivro = '$titulo',
            anoPublicLivro = '$ano', 
            edicaoLivro = '$edicao',
            tipoLivro = '$cat',
            $tipo = '$atr', 
            cnpjEditora = '$cnpj'
            WHERE codIsbnLivro = $codLivro"; 
        $this->conn->query($query);

        $q = $this->conn->query("SELECT COUNT(codExemplar) AS qtd FROM exemplar WHERE codIsbnLivro = $codLivro");
        $qtdExiste = $q->fetch_assoc();

        if($qtdExiste['qtd'] < $qtd){
            echo'lklklklk';
            $resCodExe = $this->conn->query("SELECT MAX(codExemplar) AS cod FROM exemplar");
            if($resCodExe){
                $codExemp = $resCodExe->fetch_assoc();
            }

            for($i=1; $i <= ($qtd - $qtdExiste['qtd']); $i++){
                $cod = (int)$codExemp['cod'] + $i;
                $ex = "INSERT INTO exemplar(
                    codExemplar, 
                    tipoEmprestimo, 
                    secaoLocalExemplar, 
                    corredorLocalExemplar, 
                    prateleiraLocalExemplar, 
                    codIsbnLivro) 
                VALUES ($cod, '$tipoEmp', $secao, $corr, $prat, '$codLivro')";
                $this->conn->query($ex);
            }
        } else if($qtdExiste['qtd'] > $qtd){
            for ($i = 0; $i < ($qtdExiste['qtd'] - $qtd); $i++){
                $resCodExe = $this->conn->query("SELECT MAX(codExemplar) AS cod FROM exemplar
                WHERE codIsbnLivro = $codLivro");
                $del = $resCodExe->fetch_assoc();
                $this->conn->query("DELETE FROM exemplar WHERE codExemplar =". $del['cod']);
            }
        }

        $query = "UPDATE autorlivro
        SET nomeAutor = '$autor'
        WHERE codIsbnLivro = $codLivro";
        

        if($this->conn->query($query)->num_rows > 0){
            return;
        }else {
            $query = "INSERT INTO autorlivro(codIsbnLivro, nomeAutor) VALUES ('$codLivro','$autor')";
            $this->conn->query($query);
        }
    }

    public function detalharLivro ($codLivro){
        $sql = "SELECT * FROM livro NATURAL JOIN editora WHERE codIsbnLivro = '$codLivro';";
        $res = $this->conn->query($sql);
        return $res;
    }

    public function listarAutor($codLivro){
        $query = "SELECT nomeAutor
        FROM autorLivro
        WHERE codIsbnLivro = $codLivro";
        return $this->conn->query($query);
    }

    public Function retornaExemplares($cod){
        $query = "SELECT codExemplar
        FROM exemplar
        WHERE codIsbnLivro = $cod";
        return $this->conn->query($query);
    }

    public function verificaDisponibilidade($codExemplar){
        $query = "SELECT codExemplar
        FROM exemplar NATURAL JOIN emprestimoreferente
        NATURAL JOIN emprestimo
        WHERE codExemplar = $codExemplar
        AND dataDevolvido IS NULL";
        return $this->conn->query($query);
    }

    public function excluiLivro($cod){
        $query = "DELETE
        FROM exemplar
        WHERE codIsbnLivro = $cod";
        if($this->conn->query($query)){
            $query = "DELETE
            FROM livro
            WHERE codIsbnLivro = $cod";
            if($this->conn->query($query)){
                return true;
            } else {
                echo "<h1 class='text-white bg-danger>Falha ao excluir Livro</h1>'";
                return false;
            }
        }else{
            echo "<h1 class='text-white bg-danger>Falha ao excluir Exemplares</h1>'";
            return false;
        }        
    }

    public function buscaEditora($codLivro){
        $sql = "SELECT nomeEditora 
        FROM livro NATURAL JOIN editora WHERE codIsbnLivro = $codLivro";
        return $this->conn->query($sql);
    }

    public function detalExemplares($codLivro){
        $query = "SELECT *
        FROM exemplar
        WHERE codIsbnLivro = $codLivro";
        return $this->conn->query($query);
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
        $resCodExe = $this->conn->query("SELECT MAX(codExemplar) AS cod FROM exemplar");
        if($resCodExe){
            $codExemp = $resCodExe->fetch_assoc();

        }
        for($i=1; $i <= $qtd; $i++){
            $cod = (int)$codExemp['cod'] + $i;
            $ex = "INSERT INTO exemplar(
                codExemplar, 
                tipoEmprestimo, 
                secaoLocalExemplar, 
                corredorLocalExemplar, 
                prateleiraLocalExemplar, 
                codIsbnLivro) 
            VALUES ($cod, '$tipoEmp', $secao, $corr, $prat, '$codLivro')";
            $this->conn->query($ex);
        }
        $query = "INSERT INTO autorlivro(codIsbnLivro, nomeAutor) VALUES ($codLivro,$autor)";        
    }
}
