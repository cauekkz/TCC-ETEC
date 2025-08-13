<?php
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "POST");

require_once __DIR__ . '/../../_inc/filters/isTeacher.php';

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['campus_id']) || !is_numeric($data['campus_id'])) {
    $errors[] = 'invalid ID Campus';
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}
$campus_id = $data['$campus_id'];
$sql = "SELECT id FROM campus WHERE id = :campus_id";
$params = ['campus_id' => $campus_id];
$response = $db->execute_query($sql, $params);
if ($response->status != 'success' || empty($response->results)) {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];


$sql = "INSERT INTO user_campus(user_id,campus_id) VALUES(:user_id,:campus_id)";
$params = ['campus_id' => $campus_id,'user_id' => $user_id];
$response = $db->execute_non_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

$res->response();







?>