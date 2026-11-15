<?php 
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "DELETE");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['id_comment'])) {
    $errors[] = 'invalid ID comment';
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

$id_post = $data["id_comment"];

$sql = "SELECT id_author from post where id = :id_comment";
$params = ['id_comment' => $id_post];
$response = $db->execute_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->message);
    $res->response();
    exit;
}
//
$id_author = (!empty($response->results)) ? $response->results[0]->id_author : null;
if ($id_author === null) {
    $res->set_status('error');
    $res->set_error_message("invalid post ID");
    $res->response();
    exit;
}
if ($id_author !== $user_id) {
    $res->set_status('error');
    $res->set_error_message("You're NOT the father");
    $res->response();
    exit;
}

$sql = "DELETE FROM comment where id= :id_comment";
$params = ["id_comment" => $id_comment];
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->message);
    $res->response();
    exit;
}
$res->response();






?>