<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");

if (!isset($_GET['comment_root_id'])) {
    $res->set_status('error');
    $res->set_error_message("comment_root_id");
    $res->response();
    exit;
}

$comment_root_id = $_GET['comment_root_id'];

$page = isset($_SERVER['HTTP_X_PAGE']) ? (int)$_SERVER['HTTP_X_PAGE'] : 1;
$limit = isset($_SERVER['HTTP_X_LIMIT']) ? (int)$_SERVER['HTTP_X_LIMIT'] : 10;
$offset = ($page - 1) * $limit;

$sql = "
    SELECT * 
    FROM comment 
    WHERE id_parent_comment = :comment_root_id 
    ORDER BY created_at 
    LIMIT $limit OFFSET $offset
";
$params = ['comment_root_id' => $comment_root_id];
$response = $db->execute_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

$res->set_response_data($response->results);
$res->response();
