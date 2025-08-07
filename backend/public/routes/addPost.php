<?php 
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isTeacher.php';

check_request_method($_SERVER['REQUEST_METHOD'], "POST");

require_once __DIR__ . '/../../_inc/validation/postValidator.php';

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
$serverId = $data["server_id"];

$sql = "INSERT INTO post (id_author,content,server_id) VALUES (:id_author,:content,:serverId)";
$params = ['content' => $content,"id_author"=>$user_id,"serverId"=>$serverId];
$response = $db->execute_non_query($sql, $params);


if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

$res->response();




?>