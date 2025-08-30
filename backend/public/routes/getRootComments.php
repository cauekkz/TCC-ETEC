<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");

if (!isset($_GET['comment_root_id'])) {
    $res->set_status('error');
    $res->set_error_message("erro ao pegar comentarios");
    $res->response();
    exit;
}

$comment_root_id = $_GET['comment_root_id'];

$page = isset($_SERVER['HTTP_X_PAGE']) ? (int)$_SERVER['HTTP_X_PAGE'] : 1;
$limit = isset($_SERVER['HTTP_X_LIMIT']) ? (int)$_SERVER['HTTP_X_LIMIT'] : 10;
$offset = ($page - 1) * $limit;

// Pega o user_id do token JWT
$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];

$sql = "
    SELECT 
        c.id,
        c.id_post,
        c.id_author,
        c.id_parent_comment,
        c.content,
        c.created_at,
        u.name AS author_name,
        u.profile_photo_path,
        COUNT(DISTINCT l.id) AS total_likes,
        CASE WHEN l2.id IS NULL THEN 0 ELSE 1 END AS user_liked
    FROM comment c
    LEFT JOIN user u ON u.id = c.id_author
    LEFT JOIN likes l ON l.content_type = 'comment' AND l.content_id = c.id
    LEFT JOIN likes l2 ON l2.content_type = 'comment' AND l2.content_id = c.id AND l2.user_id = :user_id
    WHERE c.id_parent_comment = :comment_root_id
    GROUP BY c.id
    ORDER BY c.created_at
    LIMIT $limit OFFSET $offset
";

$params = [
    'comment_root_id' => $comment_root_id,
    'user_id' => $user_id
];

$response = $db->execute_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message("erro ao pegar comentarios");
    $res->response();
    exit;
}

$res->set_response_data($response->results);
$res->response();
