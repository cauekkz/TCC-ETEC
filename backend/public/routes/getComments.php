<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");
$id_post;

if (isset($_GET['id_post'])) {
    $id_post = $_GET['id_post'];
} else {
    $res->set_status('error');
    $res->set_error_message("post ID");
    $res->response();
    exit;
}

$sql = "SELECT * FROM comment WHERE id_post = :id_post ORDER BY created_at";
$params = ['id_post' => $id_post];
$response = $db->execute_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
//se retorna [] nao tem NADA, primeiro add os que tem id_parent_comment == null dps organiza o resto
$res->response();
