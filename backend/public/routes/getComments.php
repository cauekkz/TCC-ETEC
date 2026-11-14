<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");

$id_post;
$page = max(1, (int)($_SERVER["HTTP_X_PAGE"] ?? 1));
$limit = min(50, max(1, (int)($_SERVER["HTTP_X_LIMIT"] ?? 20)));
$offset = ($page - 1) * $limit;

if (isset($_GET['id_post'])) {
    $id_post = $_GET['id_post'];
} else {
    $res->set_status('error');
    $res->set_error_message("post ID");
    $res->response();
    exit;
}

// Buscar comentários root (sem parent) com informações do usuário
$sql = "SELECT 
    c.id,
    c.content,
    c.created_at,
    c.id_parent_comment,
    u.name AS user_name,
    u.role AS user_role
FROM comment c
LEFT JOIN user u ON u.id = c.id_author
WHERE c.id_post = :id_post 
AND c.id_parent_comment IS NULL
ORDER BY c.created_at DESC
LIMIT $limit OFFSET $offset";

$params = [
    'id_post' => $id_post
];

$response = $db->execute_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

$res->set_response_data($response->results);
$res->response();
