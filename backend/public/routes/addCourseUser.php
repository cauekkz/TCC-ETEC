<?php
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "POST");

require_once __DIR__ . '/../../_inc/filters/isStudent.php';

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['course_id']) || !is_numeric($data['course_id'])) {
    $errors[] = 'invalid ID Course';
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}
$course_id = $data['$course_id'];
$sql = "SELECT id FROM course WHERE id = :course_id";
$params = ['course_id' => $course_id];
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


$sql = "INSERT INTO user_course(user_id,course_id) VALUES(:user_id,:course_id)";
$params = ['course_id' => $course_id,'user_id' => $user_id];
$response = $db->execute_non_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

$res->response();







?>