<?php
require("../../_inc/init.php");
require("../../_inc/sendMail.php");
session_start();
$email = $_POST['email'] ?? '';

if (!$email) {
    echo json_encode([
        "status" => "error",
        "msg" => "Informe o email"
    ]);
    exit;
}

// find the user
$sql = "SELECT id, name FROM user WHERE email = :email LIMIT 1";
$r = $db->execute_query($sql, ["email" => $email]);
$user = $r->results[0] ?? null;

// neutral response (security)
echo json_encode([
    "status" => "success",
    "msg" => "Se o email existir, você receberá a recuperação."
]);

// if it doesn't exist, stop here
if (!$user) exit;

$token = bin2hex(random_bytes(32));
$_SESSION['password_reset'] = [
    "user_id" => $user->id,
    "token" => $token,
    "expires" => time() + 3600
];

// link
$link = "http://localhost/resetpassword?token=$token";

// email body
$body = "
<h2>Recuperação de senha</h2>
<p>Olá {$user->name}</p>
<p>Clique para criar nova senha:</p>
<a href='$link'>$link</a>
<p>Esse link expira em 1 hora.</p>
";

// send
sendMail($email, "Recuperar Senha - ETEConnect", $body);
