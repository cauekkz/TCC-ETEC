<?php 
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "DELETE");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

$data = json_decode(file_get_contents('php://input'), true);
if (empty($data["followed_id"])) {
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->response();
    exit;
}
$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);

$user_id = $resultJWT['id'];
$followed_id = $data["followed_id"];

$sql = "DELETE FROM follower WHERE  followed_id = :followed_id AND follower_id = :follower_id";
$params = ["follower_id"=>$user_id,"followed_id"=>$followed_id];
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message("maksa");
    $res->response();
    exit;
}


$res->response();

?>