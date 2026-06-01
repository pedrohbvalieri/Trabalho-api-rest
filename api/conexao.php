<?php
// conexao.php
// Aqui ficam os dados pra conectar no banco
// Muda o usuario/senha se o seu XAMPP for diferente

$host = "localhost";
$usuario = "root";
$senha = "";           // No XAMPP a senha padrão é vazia
$banco = "api_produtos";

// Cria a conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica se deu erro
if ($conn->connect_error) {
    // Se falhar, retorna erro em JSON e para a execução
    http_response_code(500);
    echo json_encode(["erro" => "Falha na conexão: " . $conn->connect_error]);
    exit();
}

// Define que tudo vai ser em UTF-8 (evita problema com acentos)
$conn->set_charset("utf8");
?>