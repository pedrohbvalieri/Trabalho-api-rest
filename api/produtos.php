<?php
// produtos.php
// Esse arquivo é a API. Ele responde a requisições HTTP (GET, POST, DELETE)

// ---- HEADERS ----
// Diz pro navegador/cliente que a resposta é JSON
header("Content-Type: application/json");

// Permite que o frontend (mesmo em outro domínio/porta) acesse essa API
// Sem isso, o navegador bloqueia por segurança (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Quando o browser faz uma requisição "preflight" (OPTIONS), responde OK e para
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Inclui o arquivo de conexão com o banco
include "conexao.php";

// ---- ROTEAMENTO ----
// Descobre qual método HTTP foi usado (GET, POST, DELETE...)
$metodo = $_SERVER['REQUEST_METHOD'];

// Pega o id da URL se foi passado, ex: produtos.php?id=3
$id = isset($_GET['id']) ? intval($_GET['id']) : null;


// ========== GET ==========
// Buscar produtos
if ($metodo === 'GET') {

    if ($id) {
        // Se tem ?id=X, busca só esse produto
        $sql = "SELECT * FROM produtos WHERE id = $id";
        $resultado = $conn->query($sql);
        $produto = $resultado->fetch_assoc();

        if ($produto) {
            echo json_encode($produto);
        } else {
            http_response_code(404);
            echo json_encode(["erro" => "Produto não encontrado"]);
        }

    } else {
        // Sem id, retorna todos os produtos
        $sql = "SELECT * FROM produtos ORDER BY id DESC";
        $resultado = $conn->query($sql);

        $produtos = [];
        while ($linha = $resultado->fetch_assoc()) {
            $produtos[] = $linha;
        }

        echo json_encode($produtos);
    }
}


// ========== POST ==========
// Criar novo produto
elseif ($metodo === 'POST') {

    // Lê o corpo da requisição (o JSON enviado pelo frontend)
    $corpo = file_get_contents("php://input");
    $dados = json_decode($corpo, true); // true = vira array

    // Valida se os campos obrigatórios foram enviados
    if (empty($dados['nome']) || empty($dados['preco'])) {
        http_response_code(400); // 400 = Bad Request
        echo json_encode(["erro" => "Nome e preço são obrigatórios"]);
        exit();
    }

    // Escapa os dados pra evitar SQL Injection
    $nome  = $conn->real_escape_string($dados['nome']);
    $preco = floatval($dados['preco']);

    $sql = "INSERT INTO produtos (nome, preco) VALUES ('$nome', $preco)";

    if ($conn->query($sql)) {
        http_response_code(201); // 201 = Created
        echo json_encode([
            "mensagem" => "Produto criado com sucesso",
            "id" => $conn->insert_id // Retorna o id do novo registro
        ]);
    } else {
        http_response_code(500);
        echo json_encode(["erro" => "Erro ao criar produto"]);
    }
}


// ========== DELETE ==========
// Deletar produto por id
elseif ($metodo === 'DELETE') {

    if (!$id) {
        http_response_code(400);
        echo json_encode(["erro" => "Informe o id do produto: ?id=X"]);
        exit();
    }

    $sql = "DELETE FROM produtos WHERE id = $id";

    if ($conn->query($sql)) {
        if ($conn->affected_rows > 0) {
            echo json_encode(["mensagem" => "Produto $id deletado com sucesso"]);
        } else {
            http_response_code(404);
            echo json_encode(["erro" => "Produto não encontrado"]);
        }
    } else {
        http_response_code(500);
        echo json_encode(["erro" => "Erro ao deletar"]);
    }
}


// ========== MÉTODO NÃO SUPORTADO ==========
else {
    http_response_code(405); // 405 = Method Not Allowed
    echo json_encode(["erro" => "Método não permitido"]);
}

$conn->close();
?>