<?php 
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "DELETE");
require_once __DIR__ . '/../../_inc/filters/isTeacher.php';

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['project_id'])) {
    $errors[] = 'invalid project ID';
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);



$project_id = $data['project_id'];

$sql = "DELETE FROM tcc_project where id = :project_id";
$params = ["project_id" => $project_id];
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message("error deleting project");
    $res->response();
    exit;
}
$res->response();



?>