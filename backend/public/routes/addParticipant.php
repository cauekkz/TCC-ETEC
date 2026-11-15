<?php 
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "POST");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

require_once __DIR__ . '/../../_inc/validation/likeValidator.php';

$data = json_decode(file_get_contents('php://input'), true);


$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);

$user_id = $resultJWT['id'];
$event_id = $data['event_id'];

$sql = "INSERT INTO event_participants (event_id, user_id, registered_at) VALUES (:event_id,:user_id,NOW())";
$params = ["event_id" => $event_id,  "user_id"=>$user_id];
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->message);
    $res->response();
    exit;
}
$res->response();

?>