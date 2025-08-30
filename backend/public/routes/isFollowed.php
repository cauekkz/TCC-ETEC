<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';
check_request_method($_SERVER['REQUEST_METHOD'], "GET");
$data = $_GET;

if (empty($data['is_followed']) || !is_numeric($data["is_followed"])) {
    $errors[] = 'invalid ID followed';
    $res->set_status("error");
    $res->set_error_message("erro ao verificar se segue");
    $res->set_response_data($errors);
    $res->response();
    exit;
}

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];
$followed_id = $data["is_followed"];


$sql = "SELECT 1 FROM follower WHERE follower_id = :user_id AND followed_id = :followed_id LIMIT 1";
$params = ["user_id" => $user_id, "followed_id" => $followed_id];
$response = $db->execute_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message("erro ao verificar se segue");
    $res->response();
    exit;
}
$is_following = ($response->affected_rows > 0) ? 1 : 0;


$res->set_response_data($is_following);
$res->response();

?>