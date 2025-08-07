<?php
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "POST");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

require_once __DIR__ . '/../../_inc/validation/commentValidator.php';


$data = json_decode(file_get_contents('php://input'), true);
$errors = validate($data);
if (!empty($errors)) {
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];

$content = $data["content"];
$id_post = $data["id_post"];
$id_parent_comment =  isset($data["id_parent_comment"])? $data["id_parent_comment"] : null;

$sql = "INSERT INTO comment (id_author,content,id_post,id_parent_comment) VALUES (:id_author,:content,:id_post,:id_parent_comment)";
$params = ['content' => $content,"id_author"=>$user_id,"id_post"=>$id_post,"id_parent_comment"=>$id_parent_comment];
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

$res->response();




?>