README - API REST DE PRODUTOS (PHP + MySQL + HTML)

DESCRIÇÃO Este projeto é uma API REST simples para gerenciamento de
produtos utilizando PHP, MySQL e um frontend em HTML, CSS e JavaScript.

FUNCIONALIDADES - Listar todos os produtos - Buscar produto por ID -
Criar novo produto - Deletar produto - Exibir respostas da API em JSON

ESTRUTURA DOS ARQUIVOS

banco.sql.txt Script SQL responsável por: - Criar o banco de dados
api_produtos - Criar a tabela produtos - Inserir registros de exemplo

conexao.php Arquivo responsável pela conexão com o banco de dados MySQL.

produtos.php API REST principal. Métodos suportados: - GET - POST -
DELETE

index.html Interface gráfica que consome a API através de requisições
HTTP.

REQUISITOS - XAMPP, WAMP ou Laragon - PHP 7.4 ou superior - MySQL -
Navegador Web

INSTALAÇÃO

1.  COPIAR OS ARQUIVOS Crie uma pasta dentro do diretório htdocs do
    XAMPP.

Exemplo:

xampp/htdocs/api-rest-v1/

Coloque dentro dela: - conexao.php - produtos.php - index.html

2.  CRIAR O BANCO DE DADOS

Abra o phpMyAdmin.

Importe o arquivo banco.sql.txt.

Ou execute manualmente o script SQL.

3.  CONFIGURAR A CONEXÃO

Abra o arquivo conexao.php.

Verifique os dados:

$host = “localhost”; $usuario = “root”; $senha = ““; $banco
=”api_produtos”;

Altere caso seu ambiente utilize credenciais diferentes.

4.  AJUSTAR A URL DA API

Abra o arquivo index.html.

Localize:

const API = “http://localhost/api-rest-v1/api/produtos.php”;

Altere o caminho caso sua estrutura de pastas seja diferente.

EXECUÇÃO

1.  Inicie Apache e MySQL pelo XAMPP.
2.  Abra o navegador.
3.  Acesse:

http://localhost/api-rest-v1/index.html

A página carregará automaticamente os produtos cadastrados.

ENDPOINTS DA API

LISTAR TODOS OS PRODUTOS

Método: GET

Exemplo: http://localhost/api-rest-v1/api/produtos.php

Resposta: [ { “id”: 1, “nome”: “Camiseta”, “preco”: “49.90” }]

BUSCAR PRODUTO POR ID

Método: GET

Exemplo: http://localhost/api-rest-v1/api/produtos.php?id=1

CRIAR PRODUTO

Método: POST

Body JSON:

{ “nome”: “Notebook”, “preco”: 3500 }

Resposta:

{ “mensagem”: “Produto criado com sucesso”, “id”: 4 }

DELETAR PRODUTO

Método: DELETE

Exemplo:

http://localhost/api-rest-v1/api/produtos.php?id=4

Resposta:

{ “mensagem”: “Produto 4 deletado com sucesso” }

POSSÍVEIS ERROS

400 Dados inválidos ou ID não informado.

404 Produto não encontrado.

405 Método HTTP não permitido.

500 Erro interno ou falha de conexão com o banco.

OBSERVAÇÕES

-   A API retorna respostas em JSON.
-   O CORS está habilitado para qualquer origem.
-   O frontend utiliza Fetch API para comunicação com o backend.
-   Os dados ficam armazenados no banco MySQL.

AUTOR

Projeto educacional para estudo de API REST utilizando PHP, MySQL e
JavaScript.
