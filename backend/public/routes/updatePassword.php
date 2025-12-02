<?php
require("../../_inc/init.php");

session_start();

// ✅ Garante método PUT
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "msg" => "Método não permitido"
    ]);
    exit;
}

// ✅ Garante JSON
$data = json_decode(file_get_contents("php://input"), true);

if (
    empty($data['token']) ||
    empty($data['password'])
) {
    echo json_encode([
        "status" => "error",
        "msg" => "Dados inválidos"
    ]);
    exit;
}
$errors = [];
if (empty($data['password']) || strlen($data['password']) < 8) {
    $errors[] = 'A senha precisa ter pelo menos 8 caracteres';
} else {
    if (!preg_match('/[A-Za-z]/', $data['password'])) {
        $errors[] = 'A senha precisa conter pelo menos uma letra';
    }
    if (!preg_match('/\d/', $data['password'])) {
        $errors[] = 'A senha precisa conter pelo menos um número';
    }
    if (!preg_match('/[\W_]/', $data['password'])) {
        $errors[] = 'A senha precisa conter pelo menos um caractere especial';
    }
}
if (!empty($errors)) {
    echo json_encode([
        "status" => "error",
        "msg" => implode('. ', $errors)
    ]);
    exit;
}



// ✅ Validação do token na sessão
if (
    !isset($_SESSION['password_reset']) ||
    $_SESSION['password_reset']['token'] !== $data['token'] ||
    $_SESSION['password_reset']['expires'] < time()
) {
    echo json_encode([
        "status" => "error",
        "msg" => "Token inválido ou expirado"
    ]);
    exit;
}

$user_id = $_SESSION['password_reset']['user_id'];

// ✅ Hash seguro
$hash = password_hash($data['password'], PASSWORD_DEFAULT);

// ✅ Atualiza no banco
$sql = "UPDATE user SET password_hash = :p WHERE id = :u";
$params = ["p" => $hash, "u" => $user_id];
$db->execute_non_query($sql, $params);

// ✅ Invalida o token
unset($_SESSION['password_reset']);

echo json_encode([
    "status" => "success",
    "msg" => "Senha alterada com sucesso"
]);
