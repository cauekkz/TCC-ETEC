<?php 
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "DELETE");
require_once __DIR__ . '/../../_inc/filters/isTeacher.php';

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['notice_id'])) {
    $errors[] = 'invalid notice ID';
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);



$notice_id = $data['notice_id'];

$sql = "DELETE FROM notice where id = :notice_id";
$params = ["notice_id" => $notice_id];
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message("error deleting notice");
    $res->response();
    exit;
}
$res->response();



?>