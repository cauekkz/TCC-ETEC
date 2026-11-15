<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");

if (!isset($_GET['id_post'])) {
    $res->set_status('error');
    $res->set_error_message("erro ao pegar comentarios");
    $res->response();
    exit;
}

$id_post = $_GET['id_post'];

$page = max(1, (int)($_SERVER["HTTP_X_PAGE"] ?? 1));
$limit = min(50, max(1, (int)($_SERVER["HTTP_X_LIMIT"] ?? 20)));
$offset = ($page - 1) * $limit;

// Get user_id from the JWT token
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
        u.name AS user_name,
        u.role AS user_role,
        u.profile_photo_path,
        COUNT(DISTINCT l.id) AS total_likes,
        CASE WHEN l2.id IS NULL THEN 0 ELSE 1 END AS user_liked,
        (SELECT COUNT(*) FROM comment c2 WHERE c2.id_parent_comment = c.id) AS reply_count
    FROM comment c
    LEFT JOIN user u ON u.id = c.id_author
    LEFT JOIN likes l ON l.content_type = 'comment' AND l.content_id = c.id
    LEFT JOIN likes l2 ON l2.content_type = 'comment' AND l2.content_id = c.id AND l2.user_id = :user_id
    WHERE c.id_post = :id_post 
    AND c.id_parent_comment IS NULL
    GROUP BY c.id
    ORDER BY c.created_at DESC
    LIMIT $limit OFFSET $offset
";

$params = [
    'id_post' => $id_post,
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
