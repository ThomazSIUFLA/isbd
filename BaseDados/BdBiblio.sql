-- --------------------------------------------------------------------------
-- Criando Schema biblioSystem
-- --------------------------------------------------------------------------
CREATE SCHEMA biblioSystem DEFAULT CHARACTER SET utf8;

-- --------------------------------------------------------------------------
-- Usando o schema
-- --------------------------------------------------------------------------

USE biblioSystem;

-- --------------------------------------------------------------------------
-- Criando Table Pessoa
-- --------------------------------------------------------------------------

CREATE TABLE Pessoa (
    codPessoa                 INT(4)       NOT NULL AUTO_INCREMENT,
    nomePessoa                VARCHAR(30)  NOT NULL,
    cpfPessoa                 CHAR(11)     NULL      DEFAULT ('nao tem'), 
    emailPessoa               VARCHAR(30)  NOT NULL,
    logradouroPessoa          VARCHAR(30)  NOT NULL,
    numeroPessoa              INT(6)       NOT NULL,
    apartamentoPessoa         INT(6)       NULL,
    complementoPessoa         VARCHAR(10)  NULL,
    bairroPessoa              VARCHAR(30)  NOT NULL,
    cidadePessoa              VARCHAR(30)  NOT NULL,
    cepPessoa                 CHAR(8)      NOT NULL,
    PRIMARY KEY (codPessoa),
	CONSTRAINT uk_cpfPessoa UNIQUE (cpfPessoa),
	CONSTRAINT uk_emailPessoa UNIQUE (emailPessoa)
);

-- --------------------------------------------------------------------------
-- Criando Table TelefonePessoa
-- --------------------------------------------------------------------------

CREATE TABLE TelefonePessoa (
    codPessoa                 INT(4)       NOT NULL,
    numTelefone               VARCHAR(11)  NOT NULL,
    PRIMARY KEY (codPessoa, numTelefone),
    CONSTRAINT fk_Telefone_Pessoa
        FOREIGN KEY (codPessoa)
        REFERENCES Pessoa (codPessoa)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

-- --------------------------------------------------------------------------
-- Criando Table Aluno
-- --------------------------------------------------------------------------

CREATE TABLE Aluno (
    codPessoa                   INT(4)       NOT NULL,
    matriculaAluno              VARCHAR(10)  NOT NULL,
    turmaAluno                  VARCHAR(15)  NOT NULL,
    PRIMARY KEY (codPessoa),
	CONSTRAINT uk_matricula UNIQUE (matriculaAluno),
    CONSTRAINT fk_Aluno_Pessoa
        FOREIGN KEY (codPessoa)
        REFERENCES Pessoa (codPessoa)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

-- --------------------------------------------------------------------------
-- Criando Table Funcionario
-- --------------------------------------------------------------------------

CREATE TABLE Funcionario (
    codPessoa                   INT(4)       NOT NULL,
    codFunc                     VARCHAR(10)  NOT NULL,
    cargoFunc                   VARCHAR(20)  NOT NULL,
    turnoFunc                   VARCHAR(1)   NOT NULL,
    tipoFunc                    VARCHAR(1)   NOT NULL,
    dataInicioFuncContr         DATE     NULL,     
    dataFimFuncContr            DATE     NOT NULL,
    PRIMARY KEY (codPessoa),
    CONSTRAINT uk_codFunc UNIQUE (codFunc),
    CONSTRAINT fk_Funcionario_Pessoa
        FOREIGN KEY (codPessoa)
        REFERENCES Pessoa (codPessoa)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);
	
-- --------------------------------------------------------------------------
-- Criando Table Editora
-- --------------------------------------------------------------------------

CREATE TABLE Editora (
    cnpjEditora                 VARCHAR(14)  NOT NULL,
    nomeEditora                 VARCHAR(20) NOT NULL,
    emailEditora                VARCHAR(30) NULL,
    siteEditora                 VARCHAR(30) NULL,
    PRIMARY KEY (cnpjEditora),
    CONSTRAINT uk_emailEditora UNIQUE (emailEditora),
	CONSTRAINT uk_siteEditora UNIQUE (siteEditora)
);
	
-- --------------------------------------------------------------------------
-- Criando Table TelefoneEditora
-- --------------------------------------------------------------------------

CREATE TABLE TelefoneEditora (
    cnpjEditora                 VARCHAR(14)  NOT NULL,
    numTelefone                 VARCHAR(11)  NOT NULL,
    PRIMARY KEY (cnpjEditora, numTelefone),
    CONSTRAINT fk_Telefone_Editora
        FOREIGN KEY (cnpjEditora)
        REFERENCES Editora (cnpjEditora)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

-- --------------------------------------------------------------------------
-- Criando Table EnderecoEditora
-- --------------------------------------------------------------------------

CREATE TABLE EnderecoEditora (
    cnpjEditora                 VARCHAR(14)  NOT NULL,
    unidadeEditora              VARCHAR(20)  NULL      DEFAULT ('indisponível'),
    logradouroEditora           VARCHAR(45)  NULL      DEFAULT ('indisponível'),     
    numeroEditora               INT(6)       NULL      DEFAULT (00),
    complementoEditora          VARCHAR(10)  NULL,
    bairroEditora               VARCHAR(20)  NULL      DEFAULT ('indisponível'),
    cidadeEditora               VARCHAR(20)  NULL      DEFAULT ('indisponível'),
    cepEditora                  CHAR(8)      NULL      DEFAULT ('indispon'),
    PRIMARY KEY (cnpjEditora, unidadeEditora),
    CONSTRAINT fk_Endereco_Editora
        FOREIGN KEY (cnpjEditora)
        REFERENCES Editora (cnpjEditora)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);
	
-- --------------------------------------------------------------------------
-- Criando Table Livro
-- --------------------------------------------------------------------------

CREATE TABLE Livro (
    codIsbnLivro                CHAR(13)     NOT NULL,
    tituloLivro                 VARCHAR(30)  NOT NULL,
    anoPublicLivro              INT(4)       NULL,
    edicaoLivro                 INT(3)       NULL,
    tipoLivro                   VARCHAR(1)   NOT NULL,
    disciplinaLivroDidatico     VARCHAR(15)  NULL      DEFAULT ('Não Tem'),
    estiloLivroLiteratura       VARCHAR(20)  NULL      DEFAULT ('Não Tem'),
    cnpjEditora                 CHAR(14)     NOT NULL,
    PRIMARY KEY (codIsbnLivro),
    CONSTRAINT fk_Livro_Editora
        FOREIGN KEY (cnpjEditora)
        REFERENCES Editora (cnpjEditora)
        ON DELETE RESTRICT
        ON UPDATE NO ACTION
);
	
-- --------------------------------------------------------------------------
-- Criando Table AutorLivro
-- --------------------------------------------------------------------------

CREATE TABLE AutorLivro (
    codIsbnLivro                VARCHAR(13)  NOT NULL,
    nomeAutor                   VARCHAR(30)  NOT NULL,
    PRIMARY KEY (codIsbnLivro, nomeAutor),
    CONSTRAINT fk_AutorLivro_Livro
        FOREIGN KEY (codIsbnLivro)
        REFERENCES Livro (codIsbnLivro)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);	
	
-- --------------------------------------------------------------------------
-- Criando Table Exemplar
-- --------------------------------------------------------------------------

CREATE TABLE Exemplar (
    codExemplar                 INT(8)       NOT NULL,
    tipoEmprestimo              VARCHAR(1)   NOT NULL,
    secaoLocalExemplar          VARCHAR(10)  NOT NULL,
    corredorLocalExemplar       INT(2)       NOT NULL,
    prateleiraLocalExemplar     INT(3)       NOT NULL,
    codIsbnLivro                VARCHAR(13)  NOT NULL,
    PRIMARY KEY (codExemplar),
    CONSTRAINT fk_Exemplar_Livro1
        FOREIGN KEY (codIsbnLivro)
        REFERENCES Livro (codIsbnLivro)
        ON DELETE RESTRICT
        ON UPDATE NO ACTION
);

-- --------------------------------------------------------------------------
-- Criando Table Emprestimo
-- --------------------------------------------------------------------------

CREATE TABLE Emprestimo (
    codEmpr                     INT(8)       NOT NULL AUTO_INCREMENT,
    dataEmpr                    DATE     NOT NULL,
    dataDeovolEmpr              DATE     NOT NULL,
    dataDevolvido               DATE     NULL,
    codPessoaRealiza            INT(4)       NOT NULL,
    codFunc                     INT(4)       NOT NULL,
    PRIMARY KEY (codEmpr),
    CONSTRAINT fk_Emprestimo_Pessoa
        FOREIGN KEY (codPessoaRealiza)
        REFERENCES Pessoa (codPessoa)
        ON DELETE RESTRICT
        ON UPDATE NO ACTION,
    CONSTRAINT fk_Empr_Bibliotecario
        FOREIGN KEY (codFunc)
        REFERENCES Pessoa (codPessoa)
        ON DELETE RESTRICT
        ON UPDATE NO ACTION
);

-- --------------------------------------------------------------------------
-- Criando Table EmprestimoReferente
-- --------------------------------------------------------------------------

CREATE TABLE EmprestimoReferente (
    codExemplar                 INT(8)       NOT NULL,
    codEmpr                     INT(8)       NOT NULL,
    PRIMARY KEY (codExemplar, codEmpr),
    CONSTRAINT fk_ExemplarEmprestimo_Exemplar
        FOREIGN KEY (codExemplar)
        REFERENCES Exemplar (codExemplar)
        ON DELETE RESTRICT
        ON UPDATE NO ACTION,
    CONSTRAINT fk_ExemplarEmprestimo_Emprestimo
        FOREIGN KEY (codEmpr)
        REFERENCES Emprestimo (codEmpr)
        ON DELETE RESTRICT
        ON UPDATE NO ACTION
);

-- --------------------------------------------------------------------------
-- Alterando Table Pessoa (removendo coluna apartamentoPessoa)
-- --------------------------------------------------------------------------

ALTER TABLE pessoa
    DROP COLUMN apartamentoPessoa;
	
-- --------------------------------------------------------------------------
-- Alterando Table Pessoa (adicionando coluna dataNascPessoa)
-- --------------------------------------------------------------------------

ALTER TABLE pessoa
    ADD dataNascPessoa          DATE         NOT NULL;
	
-- --------------------------------------------------------------------------
-- Alterando Table Pessoa (Modificando tamanho do nome de 30 para 100 carac.)
-- --------------------------------------------------------------------------

ALTER TABLE pessoa 
    CHANGE nomePessoa nomePessoa VARCHAR(100) NOT NULL, 
	CHANGE emailPessoa emailPessoa VARCHAR(50) NOT NULL;
	
-- --------------------------------------------------------------------------
-- Alterando Table TelefonePessoa (adicionando coluna tipoTelefone)
-- --------------------------------------------------------------------------

ALTER TABLE telefonePessoa
    ADD tipoTelefone            CHAR(1)      NOT NULL;
	
	
-- --------------------------------------------------------------------------
-- Alterando Table emprestimo (alterando coluna dataDeovolEmpr para dataDevolEmpr)
-- --------------------------------------------------------------------------
ALTER TABLE emprestimo
    CHANGE dataDeovolEmpr dataDevolEmpr DATE NOT NULL;
	
-- --------------------------------------------------------------------------
-- Criando Table revistaTeste (criando tabela para exemplo)
-- --------------------------------------------------------------------------

CREATE TABLE revistaTeste(
    nome                      VARCHAR(30)    NOT NULL,
	cnpjEditora               VARCHAR(14)    NOT NULL,
	edicao                    INT(4)         NOT NULL,
	dataPublicacao            DATE           NOT NULL
);

-- --------------------------------------------------------------------------
-- Alterando Tabela revistaTeste (adicionando FOREIGN KEY)
-- --------------------------------------------------------------------------

ALTER TABLE revistaTeste
    ADD CONSTRAINT fk_revista_editora
	    FOREIGN KEY (cnpjEditora)
		REFERENCES editora (cnpjEditora);
		
		
		
-- --------------------------------------------------------------------------	

-- --------------------------------------------------------------------------
-- Excluindo Tabela revistaTeste
-- --------------------------------------------------------------------------
DROP TABLE revistaTeste;


-- --------------------------------------------------------------------------
-- #            INSERINDO DADOS EM CADA UMA DAS TABELAS                     #
-- --------------------------------------------------------------------------

-- ------------------------Inserido Pessoas ---------------------------------

INSERT INTO pessoa(nomePessoa, cpfPessoa, emailPessoa, logradouroPessoa, 
                   numeroPessoa, complementoPessoa, bairroPessoa, 
                   cidadePessoa, cepPessoa, dataNascPessoa) 
    VALUES  ('João Pica-Pau', '12345678901', 'joao@email.com', 'rua das flores',
		    171, 'null', 'centro', 'Lavras', '37200000', '1985-05-21'),
			('José Zezinho', '12345678902', 'zezinho@email.com', 'rua A',
		    100, 'Ap 102', 'centro', 'Lavras', '37200000', '1986-12-12'),
			('Terezinha de Jesus', '12345678903', 'terezinha@email.com', 'Av brasil',
		    1400, 'A', 'Tijuca', 'Rio de Janeiro', '45210120', '2000-05-10'),
			('Pedrinho', '12345678904', 'pedro@email.com', 'rua do fundo',
		    2, 'null', 'centro', 'Lavras', '37200000', '1988-08-05'),
			('Thomaz', '12345678905', 'thomaz@email.com', 'rua k',
		    102, 'Ap 521', 'centro', 'Lavras', '37200000', '1988-01-19'),
		    ('Maria Bonita', '12345678906', 'mbonita@email.com', 'Av cariri',
		    10, 'null', 'cangaço', 'xerem', '45810120', '2000-05-10');

-- ------------------------Inserido Telefones ---------------------------------

INSERT INTO telefonepessoa(codPessoa, numTelefone, tipoTelefone) 
    VALUES (1,'35999999999','c'),
	       (1,'3532260000','f'),
		   (1,'35999990000','s'),
		   (2,'35999991111','c'),
		   (3,'35999991112','c'),
		   (3,'35911111111','r'),
		   (4,'35922222222','c'),
		   (5,'35933333333','c'),
		   (5,'35944444444','c'),
		   (6,'35955555555','c'),
		   (6,'35966666666','f'),
		   (6,'35977777777','s');
		   
-- ------------------------Definindo Alunos ---------------------------------	
INSERT INTO aluno(codPessoa, matriculaAluno, turmaAluno) 
    VALUES  (1,'1234567890','1 A'),
	        (2,'0123456789','1 B'),
			(3,'9012345678','1 C'),
			(6,'1233333333','1 A');
			
-- ------------------------Definindo Funcionarios ---------------------------------	
INSERT INTO funcionario(codPessoa, codFunc, cargoFunc, 
                        turnoFunc, tipoFunc, dataInicioFuncContr, 
						dataFimFuncContr) 
	VALUES  (4,'15445-4', 'Bibliotecário', 'm', 'e', '2010-01-01', 'null'),
	        (5,'11111-4', 'Diretor', 'i', 'e', '2020-01-01','null');
				
				
-- ------------------------Inserindo Editoras -------------------------------------
INSERT INTO editora(cnpjEditora, nomeEditora, emailEditora, siteEditora) 
    VALUES  ('12345678901234', 'Editora Novo Tempo', 'contato@editora',
	         'www.novotempo.com'),
			('11111111111111', 'Clássica', 'contato@classica',
	         'www.editoraclassica.com'),
			('22222222222222', 'Editora Moderna', 'contato@moderna',
	         'www.editoramoderna.com');
			 
-- ------------------------Inserindo Telefone Editoras -------------------------------------
INSERT INTO telefoneeditora(cnpjEditora, numTelefone) 
    VALUES  ('11111111111111', '31352459999'),
			('22222222222222', '31387498888'),
			('12345678901234', '3138987854'),
			('12345678901234', '35999888774');


-- ------------------------Inserindo Endereço Editoras -------------------------------------
INSERT INTO enderecoeditora(cnpjEditora, unidadeEditora, logradouroEditora, numeroEditora, 
                            complementoEditora, bairroEditora, cidadeEditora, cepEditora) 
	VALUES ('11111111111111', 'matriz', 'Av central', 20, 'sala 4', 'centro', 'Lavras','37200000'),
	       ('11111111111111', 'filial', 'Rua Capitão 123 de oliveira 4', 201, null, 'Bela Vista', 'Lavras','37200000'),
		   ('22222222222222', 'Amazonas', 'Av Amazonas', 2014, null, 'centro', 'Belo Horizonte','31400000'),
		   ('12345678901234', 'Minas', 'Rua 2', 1, '3º andar', 'Primavera', 'Lavras','37200000');
				
				
-- ------------------------Inserindo Livros -------------------------------------	
INSERT INTO livro(codIsbnLivro, tituloLivro, anoPublicLivro, edicaoLivro, tipoLivro, 
                  disciplinaLivroDidatico, estiloLivroLiteratura, cnpjEditora) 
	VALUES ('548796', 'Dom Casmurro', 1954, 1, 'L', null, 
	           'romance', '11111111111111'),
	       ('1258963', 'Guerra e Paz', 1990, 2, 'L', null, 
		       'romance', '11111111111111'),
		   ('145632', 'A Montanha Mágica', 1988, 2, 'L', null, 
		       'romance', '11111111111111'),
		   ('369852', 'Cem anos de solidão', 1975, 3, 'L', null, 
		       'romance', '22222222222222'),
		   ('5214785', 'Ulisses', 2000, 5, 'L', null, 
		       'romance', '22222222222222'),
		   ('47856922', 'Em busca do tempo perdido', 2010, 1, 'L', null, 
		       'romance', '22222222222222'),
		   ('365214789', 'A Divina Comédia', 1950, 3, 'L', null, 
		       'romance', '11111111111111'),
		   ('5410236', 'O Homem sem Qualidades', 2000, 2, 'L', null, 
		       'romance', '11111111111111'),
		   ('59632014', 'O Processo', 1989, 1, 'L', null, 
		       'romance', '12345678901234'),
		   ('596321025', 'O Som e a Fúria', 2018, 2, 'L', null, 
		       'romance', '12345678901234'),
		   ('256321455', 'Crime e Castigo', 2020, 2, 'L', null, 
		       'romance', '12345678901234'),
		   ('75321590', 'Matemática sem Fronteiras', 2020, 1, 'D', 
		       'matemática', null, '12345678901234'),
		   ('75321591', 'História sem Fronteiras', 1999, 1, 'D', 
		       'História', null, '12345678901234'),
		   ('75321592', 'Português sem Fronteiras', 2000, 1, 'D', 
		       'Português', null, '12345678901234'),
		   ('75321593', 'História do mundo', 1999, 2020, 'D', 
		       'História', null, '11111111111111'),
		   ('75321594', 'Planeta terra', 2001, 3, 'D', 
		       'Geografia', null, '11111111111111'),
		   ('75321595', 'O mundo', 1995, 3, 'D', 
		       'Geografia', null, '22222222222222'),
		   ('75321596', 'A mágica dos números', 2020, 5, 'D', 
		       'matemática', null, '22222222222222'),
		   ('9876546543210', 'A Mulher na Janela', '2019', 3, 'L', 'Não Tem', 
		       'romance', '12345678901234');
		   
				
				
-- ------------------------Inserindo AutorLivros -------------------------------------
INSERT INTO autorlivro(codIsbnLivro, nomeAutor) 
    VALUES  ('1258963', 'João Jão'),
            ('145632', 'Maria Maria'),
            ('365214789', 'Antônio toninho'),
            ('5410236', 'Bento'),
            ('548796', 'Chico'),
            ('75321593', 'Pedro'),
            ('75321593', 'Juca'),
            ('75321594', 'Ricardo'),
            ('256321455', 'Ricardo'),
            ('59632014', 'Joaquim'),
            ('59632014', 'Gentil'),
            ('596321025', 'Pero Vaz Caminha'),
            ('75321590', 'Josafá'),
            ('75321591', 'José'),
			('9876546543210', 'Antônio toninho');
				
				
-- ------------------------Inserindo Exemplar -------------------------------------
INSERT INTO exemplar(codExemplar, tipoEmprestimo, secaoLocalExemplar, corredorLocalExemplar, 
                     prateleiraLocalExemplar, codIsbnLivro) 
	VALUES (1, 'M', 'Romance', 2, 3, '548796'),
	       (2, 'M', 'Romance', 2, 3, '548796'),
		   (3, 'M', 'Romance', 2, 3, '548796'),
		   (4, 'M', 'Romance', 2, 3, '548796'),
		   (5, 'M', 'Romance', 2, 3, '548796'),
		   (6, 'M', 'Romance', 2, 3, '548796'),
		   (7, 'M', 'Matemática', 4, 2, '75321590'),
		   (8, 'M', 'Matemática', 4, 2, '75321590'),
		   (9, 'M', 'Matemática', 4, 2, '75321590'),
		   (10, 'M', 'Matemática', 4, 2, '75321590'),
		   (11, 'M', 'Matemática', 4, 2, '75321590'),
		   (12, 'M', 'Matemática', 4, 2, '75321590'),
		   (13, 'M', 'Matemática', 4, 2, '75321590'),
		   (14, 'M', 'Matemática', 4, 2, '75321590'),
		   (15, 'M', 'Matemática', 4, 2, '75321590'),
		   (16, 'M', 'Matemática', 4, 2, '75321590'),
		   (17, 'M', 'Matemática', 4, 2, '75321590'),	   
		   (18, 'A', 'Linguagem', 3, 1, '75321592'),
		   (19, 'A', 'Linguagem', 3, 1, '75321592'),
		   (20, 'A', 'Linguagem', 3, 1, '75321592'),
		   (21, 'A', 'Linguagem', 3, 1, '75321592'),
		   (22, 'A', 'Linguagem', 3, 1, '75321592'),
		   (23, 'A', 'Linguagem', 3, 1, '75321592'),
		   (24, 'A', 'Linguagem', 3, 1, '75321592'),
		   (25, 'A', 'Linguagem', 3, 1, '75321592'),
		   (26, 'A', 'Linguagem', 3, 1, '75321592'),
		   (27, 'A', 'Linguagem', 3, 1, '75321592'),
		   (28, 'A', 'História', 5, 1, '75321591'),
		   (29, 'A', 'História', 5, 1, '75321591'),
		   (30, 'A', 'História', 5, 1, '75321591'),
		   (31, 'A', 'História', 5, 1, '75321591'),
		   (32, 'A', 'Geografia', 6, 2, '75321594'),
		   (33, 'A', 'Geografia', 6, 2, '75321594'),
		   (34, 'A', 'Geografia', 6, 2, '75321594'),
		   (35, 'A', 'Geografia', 6, 2, '75321594'),
		   (36, 'M', 'Romance', 2, 3, '1258963'),
		   (37, 'M', 'Romance', 2, 2, '145632'),
		   (38, 'M', 'Romance', 2, 4, '369852'),
		   (39, 'M', 'Romance', 3, 3, '5214785'),
		   (40, 'M', 'Romance', 2, 3, '47856922'),
           (41, 'M', 'Romance', 4, 3, '365214789'),
           (42, 'M', 'Romance', 4, 1, '59632014'),
           (43, 'M', 'Romance', 2, 2, '596321025'),
           (44, 'M', 'Romance', 1, 3, '256321455'),
           (45, 'A', 'História', 2, 3, '75321593'),
           (46, 'M', 'Geografia', 1, 1, '75321595'),
           (47, 'A', 'Matemática', 4, 3, '75321596'),
		   (48, 'M', 'romance', 1, 1, '9876546543210'),
		   (49, 'M', 'romance', 1, 1, '9876546543210'),
		   (50, 'M', 'romance', 1, 1, '9876546543210');
				
				
-- ------------------------Inserindo Empréstimo -------------------------------------				
INSERT INTO emprestimo(dataEmpr, dataDevolEmpr, dataDevolvido, codPessoaRealiza, codFunc) 
    VALUES ('2020-04-05', '2020-05-05', '2020-05-04', 1, 5),
	       ('2020-04-05', '2020-05-06', '2020-05-04', 6, 5),
		   ('2020-04-05', '2020-05-07', '2020-05-04', 2, 5),
		   ('2020-04-05', '2020-05-09', '2020-05-04', 3, 4),
		   ('2020-04-06', '2020-05-12', '2020-05-04', 4, 5),
		   ('2020-04-06', '2020-05-15', '2020-05-04', 5, 4),
		   ('2020-04-07', '2020-05-15', '2020-05-04', 1, 4),
		   ('2020-04-10', '2020-05-15', '2020-05-04', 2, 5),
		   ('2020-04-15', '2020-05-16', null, 3, 5),
		   ('2020-05-01', '2020-06-01', null, 6, 5),
		   ('2020-07-01', '2020-10-01', null, 1, 4),
		   ('2020-07-01', '2020-10-01', null, 3, 5);
				
				
-- ------------------------Inserindo Exemplares do Empréstimo -------------------------------------
INSERT INTO emprestimoreferente(codEmpr, codExemplar) 
    VALUES (1,1),(1,3),(1,5),(2,2),(3,6),(3,7),(4,8),(5,10),(6,12),(7,15),(8,21),(8,22),(11,44),
	       (8,23),(9,24),(9,25),(9,26),(9,20),(9,2),(10,17),(10,31),(11,47),(11,19),(11,25),(12,1);
		   

				
				
-- --------------------------------------------------------------------------	
-- --------------------------------------------------------------------------
-- #                         MODIFICANDO DADOS                              #
-- --------------------------------------------------------------------------


-- Modificando email da pessoa com nome de João Pica-Pau 
UPDATE pessoa 
    SET emailPessoa = 'picapau@email.com'
	WHERE nomePessoa = 'João Pica-Pau';
	
	
-- Modificando turma da aluna de nome Terezinha de Jesus ------------------
UPDATE aluno NATURAL JOIN 
       pessoa
SET turmaAluno = '1 A' 
WHERE nomePessoa = 'Terezinha de Jesus';

-- Alterar o telefone celular (tipo 'c') para 35988885566 do aluno com a matrícula 9012345678
UPDATE telefonePessoa NATURAL JOIN 
       pessoa NATURAL JOIN 
	   aluno
SET numTelefone = '35988885566'
WHERE matriculaAluno = '9012345678' 
AND tipoTelefone = 'c';
	
-- Alterar o endereço para Rua dos Bandeirantes, nº 150 bairro Jardim Feliz cidade Lavras
-- CEP 37200000, da editora que publicou o livro com nome de "A divina comédia"
UPDATE enderecoeditora NATURAL JOIN 
       editora NATURAL JOIN 
	   livro
SET logradouroEditora = 'Rua dos Bandeirantes', 
    numeroEditora = 150, 
	bairroEditora = 'Jardim Fiz', 
	cidadeEditora = 'Lavras',
	cepEditora = '37240000'
WHERE tituloLivro = 'A Divina Comédia';
	
-- Alterar o autor do livro 'Dom Casmurro' para Machado de Assis
UPDATE autorLivro A INNER JOIN 
       livro L
SET A.nomeAutor = 'Machado de Assis'
WHERE A.CodIsbnLivro = L.CodIsbnLivro
AND L.tituloLivro = 'Dom Casmurro';
	
	
-- Realizar a devolução do emprestimo realizado por 'Maria Bonita' no dia 01/05/2020
UPDATE emprestimo E, 
       pessoa P 
SET dataDevolvido = (SELECT NOW())
WHERE E.codPessoaRealiza = P.codPessoa
AND E.dataEmpr = '2020-05-01';	
	


-- --------------------------------------------------------------------------	
-- --------------------------------------------------------------------------
-- #                         EXCLUINDO DADOS                              #
-- --------------------------------------------------------------------------

-- Excluir o telefone número 35999888774 da editora em que pertence
DELETE FROM telefoneeditora
    WHERE numTelefone = '35999888774';
	
-- Excluir o livro Crime e Castigo do Empréstimo realizado no dia 01/07/2020 
-- pela pessoa com o telefone 35999999999
DELETE FROM emprestimoreferente
WHERE codExemplar = (
    SELECT codExemplar 
    FROM exemplar NATURAL JOIN 
	     livro 
	WHERE tituloLivro = 'Crime e Castigo')
AND codEmpr = (
	SELECT codEmpr 
	FROM emprestimo INNER JOIN 
	     pessoa
	WHERE emprestimo.codPessoaRealiza = pessoa.codPessoa
    AND emprestimo.dataEmpr = '2020-07-01'
	AND pessoa.codPessoa = (
	    SELECT codPessoa
	    FROM pessoa NATURAL JOIN telefonePessoa 
		WHERE numTelefone = '35999999999') 
);
	
	
-- Excluir o último empréstimo autorizado pelo diretor
-- (Exemplo com Exlusão não realizada, pois está sendo referenciado
--  por chave estrangeira na tabela empréstimoReferente)
-- Obs: Será criado um STORE PROCEDURE para realizar tal operação
/*
DELETE FROM emprestimo
WHERE codFunc = (
    SELECT codPessoa 
    FROM pessoa NATURAL JOIN 
	     funcionario
    WHERE cargoFunc = 'diretor')
AND dataEmpr = (
    SELECT MAX(dataEmpr) 
	FROM emprestimo);
*/

-- Exclua todos exemplares do livro O Mundo
DELETE FROM exemplar
    WHERE codIsbnLivro = (
	    SELECT codIsbnLivro
		FROM livro
		WHERE tituloLivro = 'O Mundo');
		

-- Exclua o livro com o nome 'O Munco'
DELETE FROM livro
WHERE tituloLivro = 'O Mundo';
	
	

-- --------------------------------------------------------------------------	
-- --------------------------------------------------------------------------
-- #                         CONSULTANDO DADOS                              #
-- --------------------------------------------------------------------------

-- Selecione o título, o ano de publicação o código ISBN de todos os livros
-- publicados pela editora 'Clássica' e exiba por ordem alfabética do título
-- alterando o nome das colunas para facilitar a leitura.
SELECT tituloLivro AS 'Título', 
       anoPublicLivro AS 'Publicado em', 
	   codIsbnLivro AS 'ISBN'
FROM livro NATURAL JOIN 
     editora
WHERE nomeEditora = 'Clássica'
ORDER BY tituloLivro;

-- Selecione a quantidade de livros de cada editora, ordene da maior quantidade para a menor, depois por nome da editora
SELECT COUNT(codIsbnLivro) AS qtdLivro, 
       nomeEditora as editora
FROM livro NATURAL JOIN
     editora
GROUP BY nomeEditora
ORDER BY qtdLivro DESC, editora;

-- Selecione a quantidade de exemplares e o nome do livro, mostre somente os livros que possuem mais de 4 exemplares
-- Ordene da maior para menor quantidade e depois pelo título do livro
SELECT COUNT(codExemplar) AS qtdExemplar, 
       tituloLivro AS título
FROM livro NATURAL JOIN
     exemplar
GROUP BY tituloLivro
HAVING qtdExemplar > 4
ORDER BY qtdExemplar DESC, tituloLivro ASC;	


-- Selecione o nome, telefone celular e endereço de todos os alunos nascidos de 01/01/1985,
-- inclusive até 31/12/2005 inclusive, ordenados pela data de nascimento, os mais velhos primeiro
SELECT nomePessoa AS 'Nome', 
       dataNascPessoa AS 'Data de Nascimento', 
	   numTelefone AS 'Telefone', 
       logradouroPessoa AS 'Rua', 
	   numeroPessoa AS 'Nº', 
	   bairroPessoa AS 'Bairro', 
	   cidadePessoa AS 'Cidade'
FROM pessoa NATURAL JOIN 
     aluno NATURAL JOIN 
	 telefonePessoa
WHERE dataNascPessoa BETWEEN '1985-01-01' AND '2005-12-31' AND 
      tipoTelefone = 'c'
ORDER BY dataNascPessoa ASC;

-- Selecione os nomes das pessoas, título dos livros, data do empréstimo e data de
-- devolução de todos os empréstimos
SELECT nomePessoa AS 'Nome', 
       tituloLivro AS 'Título', 
	   dataEmpr AS 'Data do Empréstimo',
       dataDevolEmpr AS 'Data de vencimento'
FROM pessoa P, 
     emprestimo E, 
	 livro L, 
	 emprestimoreferente N, 
	 exemplar X
WHERE X.codIsbnLivro = L. codIsbnLivro AND 
      N.codEmpr = E.codEmpr AND 
	  E.codPessoaRealiza = P.codPessoa AND 
	  N.codExemplar = X.codExemplar;
	  
-- Selecione o nome da pessoa, telefone celular, email e código do empréstimo, quantidade de dias de atraso, 
-- quantidade de livros e o nome do funcionário que autorizou, de todos os empréstimos que estão em atraso,
-- Ordenar pelos que estão a mais tempo atrasado primeiro, e depois por nome em ordem alfabética
SELECT P.nomePessoa AS 'Nome', 
       T.numTelefone AS 'Telefone', 
	   P.emailPessoa AS 'e-mail', 
	   E.codEmpr AS 'códigoEmpréstimo', 
       COUNT(E.codEmpr) AS 'Quantidade de Livros', 
	   DATEDIFF (E.dataDevolEmpr, NOW()) AS 'DiasAtrasado' ,
	   Q.nomePessoa AS 'Funcionario'        	   
FROM pessoa P INNER JOIN 
     emprestimo E INNER JOIN 
	 pessoa Q INNER JOIN 
	 telefonePessoa T INNER JOIN 
	 emprestimoreferente N INNER JOIN 
	 exemplar X
WHERE E.codPessoaRealiza = P.codPessoa AND 
      E.codFunc = Q.codPessoa AND 
	  T.codPessoa = P.codPessoa AND 
	  T.tipoTelefone = 'c' AND 
	  N.codEmpr = E.codEmpr AND 
	  X.codExemplar = N.codExemplar AND 
	  DATEDIFF (E.dataDevolEmpr, NOW()) > 0
GROUP BY E.codEmpr
ORDER BY DiasAtrasado DESC, Nome ASC;

-- Selecione o nome e email e a data do empréstimo de todos alunos que já pegaram o livro com nome de 'Dom Casmurro'
-- ou que já pegaram algum livro publicado pela editora 'Editora Moderna'
SELECT nomePessoa AS 'Nome',
       codEmpr AS 'cód Emprestimo',
       emailPessoa AS 'email',
	   dataEmpr AS 'Data do Empréstimo'
FROM Pessoa NATURAL JOIN
     aluno INNER JOIN
	 emprestimoreferente NATURAL JOIN
	 emprestimo NATURAL JOIN
	 livro NATURAL JOIN
	 exemplar
WHERE emprestimo.codPessoaRealiza = aluno.codPessoa AND
      (exemplar.codIsbnLivro = (
	       SELECT codIsbnLivro
		   FROM livro
		   WHERE tituloLivro = 'Dom Casmurro') OR
	  livro.cnpjEditora = (
	      SELECT cnpjEditora
		  FROM editora
		  WHERE nomeEditora = 'Editora Moderna'));
		  
		  
-- Selecione o nome e telefone do tipo fixo ('f') de todas as pessoas, 
-- se não tiver liste apenas o nome, colocando null no lugar do telefone
SELECT nomePessoa AS 'Nome', 
       numTelefone AS 'Telefone Fixo'
FROM pessoa P LEFT OUTER JOIN
     telefonePessoa T 
ON P.codPessoa = T.codPessoa AND
T.tipoTelefone = 'f' OR 'F';

-- SELECIONE o título e o código ISBNtodos os livros do autor de nome 'Antônio toninho' 
-- que não foram publicados pela editora 'Clássica'
SELECT tituloLivro AS 'Título',
       codIsbnLivro AS 'ISBN',
	   nomeEditora AS 'Editora'
FROM livro NATURAL JOIN
     autorLivro NATURAL JOIN
	 editora
WHERE autorLivro.nomeAutor = 'Antônio toninho' AND
      cnpjEditora NOT IN (
	      SELECT cnpjEditora
		  FROM editora
		  WHERE nomeEditora = 'Clássica');

-- Selecione o título do livro, código isbn, ano de publicação dos livros lançados entre 
-- 2000 e 2020 e que não tem registro de empréstimo'
SELECT tituloLivro AS 'Título', 
       codIsbnLivro AS 'ISBN',
	   anoPublicLivro AS 'Ano Publicação'
FROM livro NATURAL JOIN 
     exemplar NATURAL JOIN
	 emprestimoreferente NATURAL JOIN
	 emprestimo
WHERE anoPublicLivro BETWEEN 2000 AND 2020 AND
      codIsbnLivro NOT IN (
          SELECT codIsbnLivro
		  FROM livro NATURAL JOIN 
		       exemplar NATURAL JOIN
			   emprestimoreferente NATURAL JOIN
			   emprestimo);
			   
-- Selecione o nome e data de aniversário (dia e mês) de todas as pessoas que possui o 
-- nome 'João' em algum lugar de seu nome completo
SELECT nomePessoa AS 'Nome', 
       DATE_FORMAT(dataNascPessoa, '%d/%m') AS 'Dia do Aniversário'
FROM pessoa
WHERE nomePessoa LIKE '%joao%';

-- Recupere o nome a edição e o autor dos livros publicados pelas editoras 'Clássica' ou 'Novo Tempo'
SELECT tituloLivro AS 'Título do Livro',
       edicaoLivro AS 'edição',
       nomeAutor AS 'Autor'
FROM livro NATURAL JOIN
     autorLivro NATURAL JOIN
	 editora
WHERE nomeEditora IN ('Clássica', 'Novo Tempo');

-- Selecione o titulo a edição e o código ISBN dos livros que foram publicados
-- após o nascimento da pessoa mais nova que mora na cidade de lavras 
SELECT tituloLivro AS 'Título', 
       edicaoLivro AS 'Edição', 
	   codIsbnLivro AS 'ISBN'
FROM livro
WHERE anoPublicLivro < SOME (
    SELECT DATE_FORMAT(dataNascPessoa, '%Y')
    FROM pessoa
    WHERE cidadePessoa = 'Lavras');


-- Recupere o título, ano publicação, editora, autor e ISBN dos livros que foram escritos
-- pelo autor 'Antônio toninho' ou foram publicados pela editora 'Clássica'
SELECT tituloLivro AS 'Nome',
       anoPublicLivro AS 'Ano de Publicação',
	   nomeEditora AS 'Editora',
       nomeAutor AS 'Autor'
FROM livro NATURAL JOIN
     editora NATURAL JOIN
	 autorLivro
WHERE nomeAutor = 'Antônio toninho'
UNION
SELECT tituloLivro AS 'Nome',
       anoPublicLivro AS 'Ano de Publicação',
	   nomeEditora AS 'Editora',
       nomeAutor AS 'Autor'
FROM livro NATURAL JOIN
     editora NATURAL JOIN
	 autorLivro
WHERE nomeEditora = 'Clássica';

-- Recupere o título, edição e ano de publicação dos livros que nunca foram emprestados
SELECT tituloLivro,
       edicaoLivro,
	   anoPublicLivro
FROM livro L
WHERE NOT EXISTS (
    SELECT *
	FROM exemplar E,
	     emprestimoreferente X
	WHERE L.codIsbnLivro = E.codIsbnLivro AND
	      E.codExemplar = X.codExemplar);
	 
-- Recupere o titulo e ano de publicação dos livros que não foram publicados na década de 90
-- e foram publicados pela editora 'Novo Tempo'
SELECT tituloLivro,
       anoPublicLivro
FROM livro
WHERE anoPublicLivro NOT BETWEEN 1990 AND 1999
INTERSECT
SELECT tituloLivro,
       anoPublicLivro
FROM livro NATURAL JOIN
     editora
WHERE nomeEditora = 'Editora Novo Tempo';



-- --------------------------------------------------------------------------	
-- --------------------------------------------------------------------------
-- #                         CRIANDO VIEWS                             #
-- --------------------------------------------------------------------------

-- Crie uma visão que armazene o código do empréstimo nome da pessoa, 
-- a data do empréstimo, a quantidade títulos do emprestimo e quem autorizou
-- ordene por data, os mais novos primeiro
CREATE VIEW emprestimoPessoa (codEmprestimo, nome, dataEmprestimo, qtdLivros, funcionario)AS
    SELECT E.codEmpr AS codEmprestimo,
	       P.nomePessoa AS nome,
		   E.dataEmpr AS dataEmprestimo,
		   COUNT(X.codExemplar) AS qtdLivros,
		   Q.nomePessoa AS funcionario
	FROM pessoa P,
	     emprestimo E,
         emprestimoreferente N,
         exemplar X,
		 pessoa Q,
		 livro L
	WHERE E.codEmpr = N.codEmpr AND
	      N.codExemplar = X.codExemplar AND
		  X.codIsbnLivro = L.codIsbnLivro AND
		  E.codPessoaRealiza = P.codPessoa AND
		  Q.codPessoa = E.codFunc
	GROUP BY E.codEmpr
	ORDER BY dataEmprestimo DESC;

-- Use a visão em uma consulta
-- -----------------------------
-- Selcione o código e o nome de quem realizou todos os empréstimos autorizados pelo funcionário de nome 'Pedrinho'		 
SELECT codEmprestimo, 
       nome
FROM emprestimoPessoa
WHERE funcionario = 'Pedrinho';

-- Mostre o código do emprestimo, o nome da pessoa e a quantidade de livros, se for mais que 3
SELECT codEmprestimo, 
       nome, 
	   qtdLivros
FROM emprestimoPessoa
WHERE qtdLivros > 3;


-- Crie uma visão onde coloque a data, a quantidade de todos empréstimos realizados no dia
-- e a quantidade de livros emprestados, Ordene dos mais novos para os mais antigos
CREATE VIEW emprestimoPorDia (dataEmprestimo, qtdEmprestimo, qtdLivros) AS
    SELECT dataEmprestimo,
	       COUNT(codEmprestimo) AS qtdEmprestimo,
		   SUM(qtdLivros)
	FROM emprestimoPessoa
	GROUP BY dataEmprestimo
	ORDER BY dataEmprestimo DESC;
	
-- Mostre a quantidade de emprestimos e a quantidade de livros emprestados realizados no mês de abril de 2020
SELECT SUM(qtdEmprestimo) AS EmprestimosAbril,
       SUM(qtdLivros) AS QtdLivrosEmprestados
FROM emprestimoPorDia
WHERE DATE_FORMAT(dataEmprestimo, '%m/%y') = '04/20';


-- Crie uma visão que armazene o código da pessoa nome da pessoa, telefone celular o código do emprestimo, 
-- a data de vencimento do empréstimo, e a quantidade de dias em atraso de todos empréstimos atrasados
CREATE VIEW emprestimosAtrasados (codPessoa, Nome, Telefone, dataVencimento, DiasAtrasado) AS
SELECT P.codPessoa,
       P.nomePessoa AS Nome, 
       T.numTelefone AS Telefone, 
       E.dataDevolEmpr AS dataVencimento, 
	   DATEDIFF (E.dataDevolEmpr, NOW()) AS DiasAtrasado   	   
FROM pessoa P INNER JOIN 
     emprestimo E INNER JOIN 
	 telefonePessoa T INNER JOIN 
	 emprestimoreferente N INNER JOIN 
	 exemplar X
WHERE E.codPessoaRealiza = P.codPessoa AND
	  T.codPessoa = P.codPessoa AND 
	  T.tipoTelefone = 'c' AND 
	  N.codEmpr = E.codEmpr AND 
	  X.codExemplar = N.codExemplar AND 
	  DATEDIFF (E.dataDevolEmpr, NOW()) > 0
GROUP BY E.codEmpr
ORDER BY DiasAtrasado DESC, Nome ASC;

-- Recupere o nome, telefone e email de todas as pessoas que estão a mais de 30 dias de atraso
SELECT Nome,
       Telefone,
	   emailPessoa AS 'e-mail'
FROM emprestimosAtrasados NATURAL JOIN
     pessoa
WHERE DiasAtrasado >= 30;



-- --------------------------------------------------------------------------	
-- --------------------------------------------------------------------------
-- #                         CRIANDO USUÁRIOS                               #
-- --------------------------------------------------------------------------
-- usuário bibliotecário
CREATE USER 'bibliotecario'@'localhost' IDENTIFIED BY '123456';

-- usuário aluno
CREATE USER 'aluno'@'localhost' IDENTIFIED BY '567890';

-- usuário administrador
CREATE USER 'admin'@'localhost' IDENTIFIED BY '654321';

-- --------------------------------------------------------------------------	
-- --------------------------------------------------------------------------
-- #                         CONCEDENDO PERIMISSÕES                         #
-- --------------------------------------------------------------------------
-- Permissão para bibliotecário
GRANT ALL ON BiblioSystem.livro TO 'bibliotecario'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.pessoa TO 'bibliotecario'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.aluno TO 'bibliotecario'@'localhost';
GRANT ALL ON BiblioSystem.emprestimo TO 'bibliotecario'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.autorLivro TO 'bibliotecario'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.editora TO 'bibliotecario'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.emprestimoreferente TO 'bibliotecario'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.enderecoeditora TO 'bibliotecario'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.exemplar TO 'bibliotecario'@'localhost';
GRANT SELECT ON BiblioSystem.funcionario TO 'bibliotecario'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.telefoneeditora TO 'bibliotecario'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.telefonePessoa TO 'bibliotecario'@'localhost';
GRANT SELECT ON BiblioSystem.emprestimoPessoa TO 'bibliotecario'@'localhost';
GRANT SELECT ON BiblioSystem.emprestimosatrasados TO 'bibliotecario'@'localhost';


-- Permissão para aluno
GRANT ALL ON BiblioSystem.livro TO 'aluno'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.pessoa TO 'aluno'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.aluno TO 'aluno'@'localhost';
GRANT ALL ON BiblioSystem.emprestimo TO 'aluno'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.autorLivro TO 'aluno'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.editora TO 'aluno'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.emprestimoreferente TO 'aluno'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.enderecoeditora TO 'aluno'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.exemplar TO 'aluno'@'localhost';
GRANT SELECT ON BiblioSystem.funcionario TO 'aluno'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.telefoneeditora TO 'aluno'@'localhost';
GRANT SELECT, INSERT ON BiblioSystem.telefonePessoa TO 'aluno'@'localhost';
GRANT SELECT ON BiblioSystem.emprestimoPessoa TO 'aluno'@'localhost';
GRANT SELECT ON BiblioSystem.emprestimosatrasados TO 'aluno'@'localhost';

-- Permissão para Administrador
GRANT ALL ON BiblioSystem TO 'admin'@'localhost'


-- --------------------------------------------------------------------------
-- #                         REVOGANDO PERIMISSÕES                          #
-- --------------------------------------------------------------------------

-- Revogando permissões bibliotecário
REVOKE UPDATE, DELETE (codLivro) ON BiblioSystem.livro FROM 'bibliotecario'@'localhost';
REVOKE DELETE ON BiblioSystem.emprestimo FROM 'bibliotecario'@'localhost';


-- Revogando permissões aluno
REVOKE ALL ON BiblioSystem.livro FROM 'aluno'@'localhost';
REVOKE DELETE, UPDATE, INSERT ON BiblioSystem.emprestimo FROM 'aluno'@'localhost';
REVOKE SELECT, INSERT ON BiblioSystem.aluno FROM 'aluno'@'localhost';
REVOKE ALL ON BiblioSystem.emprestimo FROM 'aluno'@'localhost';
REVOKE INSERT ON BiblioSystem.autorLivro FROM 'aluno'@'localhost';
REVOKE INSERT ON BiblioSystem.editora FROM 'aluno'@'localhost';
REVOKE INSERT ON BiblioSystem.emprestimoreferente FROM 'aluno'@'localhost';
REVOKE INSERT ON BiblioSystem.enderecoeditora FROM 'aluno'@'localhost';
REVOKE INSERT ON BiblioSystem.exemplar FROM 'aluno'@'localhost';
REVOKE ALL ON BiblioSystem.funcionario FROM 'aluno'@'localhost';
REVOKE INSERT ON BiblioSystem.telefoneeditora FROM 'aluno'@'localhost';
REVOKE INSERT ON BiblioSystem.telefonePessoa FROM 'aluno'@'localhost';
REVOKE ALL ON BiblioSystem.emprestimoPessoa FROM 'aluno'@'localhost';
REVOKE SELECT ON BiblioSystem.emprestimosatrasados FROM 'aluno'@'localhost';


-- --------------------------------------------------------------------------
-- #                         CRIANDO STORE PROCEDURES                       #
-- --------------------------------------------------------------------------

-- Procedimento para inserir aluno
USE BiblioSystem
DELIMITER $$
CREATE PROCEDURE InsereAluno(
    IN aNome         VARCHAR(100),
    IN aCpf          CHAR (11),
    IN aLogradouro   VARCHAR(30),
    IN aNumero       INT(6),
    IN aComplemento  VARCHAR(10),
    IN aBairro       VARCHAR(30),
    IN aCidade       VARCHAR(30),
    IN aCep          VARCHAR(8),
    IN aDataNasc     DATE,
    IN aEmail        VARCHAR(50),
    IN aturma        CHAR (15),
    IN aMatricula    VARCHAR(10),
	OUT cod         INT(8)
)
BEGIN
DECLARE codP INT(8);
INSERT INTO pessoa(
	nomePessoa, 
	cpfPessoa, 
	emailPessoa, 
	logradouroPessoa, 
	numeroPessoa, 
	complementoPessoa, 
	bairroPessoa, 
	cidadePessoa, 
	cepPessoa, 
	dataNascPessoa) 
VALUES (
    aNome,
    aCpf,
	aEmail,
    aLogradouro,
    aNumero,
    aComplemento,
    aBairro,
    aCidade,
    aCep,
    aDataNasc);
SELECT codPessoa FROM pessoa WHERE emailPessoa = aEmail INTO codP;
INSERT INTO aluno(
    codPessoa, 
	matriculaAluno, 
	turmaAluno)
VALUES (codP,
    aMatricula,
	aturma);
SET cod = codP;
END$$
DELIMITER ;

-- Executando
CALL InsereAluno(
    'Joaquim José da Silva',
    '11109876543',
    'Av Dinossauro',
    150,
    'Ap 302',
    'Porteira',
    'São Thomé das Letras',
    '37450000',
    '2005-02-12',
    'joajosil@email.com',
    '2 A',
    '9876543201',
	@cod);
SELECT @cod AS cod;



-- Procedimento inserir TelefonePessoa
USE BiblioSystem;
DELIMITER $$
CREATE PROCEDURE insereTelefonePessoa(
    IN aCodPessoa INT(8),
	IN aTelefone VARCHAR (11),
	IN aTipoTelefone CHAR(1))
BEGIN
INSERT INTO telefonePessoa(
    codPessoa,
	numTelefone,
	tipoTelefone)
VALUES (
    aCodPessoa,
	aTelefone,
	aTipoTelefone);
END $$
DELIMITER ;

-- Executando
CALL insereTelefonePessoa (10, '35997780000','c');


-- Procedimento excluir emprestimo
USE BiblioSystem;
DELIMITER $$
CREATE PROCEDURE excluirEmprestimo(
    IN aCodEmpr INT(8))
BEGIN
DELETE FROM emprestimoreferente
WHERE codEmpr = aCodEmpr;
DELETE FROM emprestimo
WHERE codEmpr = aCodEmpr;
END $$
DELIMITER ;

-- Executando
CALL excluirEmprestimo(8);


-- Procedimento retornar código, nome, telefone, código do empréstimo e 
-- dias de atraso de todos alunos com empréstimo atrasado
USE BiblioSystem;
DELIMITER $$
CREATE PROCEDURE retornaAlunosComAtraso()
BEGIN
SELECT P.codPessoa AS Codigo, 
       P.nomePessoa AS Nome, 
	   T.numTelefone AS Telefone,
	   codEmpr, 
	   DATEDIFF (E.dataDevolEmpr, NOW()) AS diasAtrasado
FROM pessoa P INNER JOIN 
     emprestimo E INNER JOIN 
	 telefonePessoa T
WHERE E.codPessoaRealiza = P.codPessoa AND
	  T.codPessoa = P.codPessoa AND 
	  T.tipoTelefone = 'c' AND 
	  DATEDIFF (E.dataDevolEmpr, NOW()) > 0
ORDER BY DiasAtrasado DESC, Nome ASC;
END $$
DELIMITER ;

-- Executando
CALL retornaAlunosComAtraso();

-- Procedimento retornar quantidade de livros emprestados atualmente
USE BiblioSystem;
DELIMITER $$
CREATE PROCEDURE retornaQtdLivrosEmprestados()
BEGIN
SELECT COUNT(codExemplar)
FROM emprestimoreferente NATURAL JOIN
     emprestimo
WHERE dataDevolvido IS NULL;
END $$
DELIMITER ;

-- Executando
CALL retornaQtdLivrosEmprestados();



-- --------------------------------------------------------------------------
-- #                         CRIANDO TRIGGERS                               #
-- --------------------------------------------------------------------------

-- Crie um TRIGGER para armazenar todas as mudanças nos empréstimos

-- Tabelas auxiliares para guardar os registros
CREATE TABLE auditoriaAlterarEmprestimo (
    idAuditoria       INT(8)     NOT NULL AUTO_INCREMENT PRIMARY KEY,
	idFuncionario     INT(8)     NOT NULL,
	nomeFuncionario   VARCHAR(100) NOT NULL,
	codEmpr           INT(8)     NOT NULL,
	codPessoaAnt      INT(8)     NOT NULL,
	nomePessoaAnt     VARCHAR(100) NOT NULL,
	dataEmpAnt        DATE       NOT NULL,
	dataDevolEmprAnt  DATE       NOT NULL,
	dataDevolvidoAnt  DATE           NULL,
	codPessoaNew      INT(8)     NOT NULL,
	nomePessoaNew     VARCHAR(100) NOT NULL,
	dataEmpNew        DATE       NOT NULL,
	dataDevolEmprNew  DATE       NOT NULL,
	dataDevolvidoNew  DATE           NULL,
    usuario	          VARCHAR    NOT NULL,
	dataHora          DATETIME   NOT NULL
)

-- Criação do TRIGGER
DELIMITER $$
CREATE TRIGGER after_Emprestimo_Update
AFTER UPDATE ON emprestimo
FOR EACH ROW
BEGIN
    INSERT INTO auditoriaAlterarEmprestimo(
	    idFuncionario,
		nomeFuncionario,
		codEmpr,
		codPessoaAnt,
		nomePessoaAnt,
		dataEmpAnt,
		dataDevolEmprAnt,
		datadevolvidoAnt,
		codPessoaNew,
		nomePessoaNew,
		dataEmpNew,
		dataDevolEmprNew,
		datadevolvidoNew,
		usuario,
		dataHora
		)
	VALUE (NEW.codFunc, 
	      (SELECT nomePessoa 
	           FROM pessoa
			   WHERE codPessoa = NEW.codFunc),
		   OLD.codEmpr,
		   OLD.codPessoaRealiza,
		   (SELECT nomePessoa
		       FROM pessoa
			   WHERE codPessoa = OLD.codPessoaRealiza),
		   OLD.dataEmpr,
		   OLD.dataDevolEmpr,
		   OLD.dataDevolvido,
		   NEW.codPessoaRealiza,
		   (SELECT nomePessoa
		       FROM pessoa
			   WHERE codPessoa = NEW.codPessoaRealiza),
		   NEW.dataEmpr,
		   NEW.dataDevolEmpr,
		   NEW.dataDevolvido,
		   USER(),
		   NOW()
		);
END$$
DELIMITER ;

-- Alterando empréstimo para disparar o TRIGGER
UPDATE emprestimo
SET dataDevolvido = null
WHERE codPessoaRealiza = 2
AND dataEmpr = '2020-05-01';



-- Criação de TRIGGER para validar Telefone
DELIMITER $$
CREATE TRIGGER before_TelefonePessoa_insert
BEFORE INSERT ON telefonePessoa
FOR EACH ROW
BEGIN
    IF (new.tipoTelefone NOT IN ('c','C','f','F','r','R') ) THEN
        SIGNAL SQLSTATE '45000' SET message_text = 'Tipo de telefone inválido, informe f ou F para fixo, c ou C para celular, r ou R para residencial';
    END IF;
    IF (new.codPessoa NOT IN (SELECT codPessoa FROM pessoa)) THEN
        SIGNAL SQLSTATE '45001' SET message_text = 'Código da pessoa não existe, TENTE NOVAMENTE';
    END IF;		
END$$
DELIMITER ;

-- DISPARANDO
INSERT INTO telefonepessoa(codPessoa, numTelefone, tipoTelefone) 
    VALUES (18,'35999556989','c');
	
INSERT INTO telefonepessoa(codPessoa, numTelefone, tipoTelefone) 
    VALUES (5,'35999556989','b');
	
	
-- Criação de TRIGGER para verificar quantidade de livros do empréstimo
-- Não pode ser mais que 5
DELIMITER $$
CREATE TRIGGER before_LivrosEmprestimo_insert
BEFORE INSERT ON emprestimoreferente
FOR EACH ROW
BEGIN
    DECLARE qtdLivros  INT;
    SELECT COUNT(codExemplar) INTO qtdLivros
    FROM emprestimoreferente
    WHERE codEmpr = new.codEmpr;	
	
    IF (qtdLivros = 5) THEN
        SIGNAL SQLSTATE '45000' SET message_text = 'Só é permitido 5 unidades por empréstimo';
    END IF;		
END$$
DELIMITER ;

-- DISPARANDO
INSERT INTO emprestimoreferente(codEmpr, codExemplar) VALUES (1,20);
INSERT INTO emprestimoreferente(codEmpr, codExemplar) VALUES (1,21);
INSERT INTO emprestimoreferente(codEmpr, codExemplar) VALUES (1,22);
INSERT INTO emprestimoreferente(codEmpr, codExemplar) VALUES (2,23);
INSERT INTO emprestimoreferente(codEmpr, codExemplar) VALUES (1,28);
	



