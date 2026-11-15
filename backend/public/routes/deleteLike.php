<?php 
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "DELETE");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

require_once __DIR__ . '/../../_inc/validation/likeValidator.php';

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

$content_type = $data["content_type"];
$content_id = $data["content_id"];

$sql = "DELETE FROM likes where user_id = :user_id AND content_type = :content_type AND content_id = :content_id";
$params = ["user_id"=>$user_id,"content_id"=>$content_id,"content_type"=>$content_type];
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->message);
    $res->response();
    exit;
}
$res->response();



?>